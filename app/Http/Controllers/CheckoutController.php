<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(CartService $cartService): View|RedirectResponse
    {
        if ($cartService->isEmpty()) {
            return redirect()->route('shop')->with('error', __('ui.flash.cart_empty'));
        }

        return view('checkout.index', [
            'cartItems' => $cartService->content(),
            'subtotal' => $cartService->subtotal(),
            'user' => request()->user(),
        ]);
    }

    public function store(CheckoutRequest $request, CartService $cartService): RedirectResponse
    {
        $cartItems = $cartService->content();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop')->with('error', __('ui.flash.cart_empty'));
        }

        $productIds = $cartItems->pluck('product.id')->all();
        $payload = $request->validated();

        $order = DB::transaction(function () use ($cartItems, $productIds, $payload, $request, $cartService) {
            $products = Product::query()
                ->whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($cartItems as $item) {
                $product = $products->get($item['product']->id);

                if (! $product || ! $product->is_active || $product->quantity < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'cart' => __('ui.flash.stock_changed', ['product' => $item['product']->localized_name]),
                    ]);
                }
            }

            $order = Order::create([
                'user_id' => $request->user()?->id,
                'order_number' => $this->generateOrderNumber(),
                'first_name' => $payload['first_name'],
                'last_name' => $payload['last_name'],
                'email' => $payload['email'],
                'phone' => $payload['phone'] ?? null,
                'address' => $payload['address'],
                'city' => $payload['city'],
                'postal_code' => $payload['postal_code'],
                'country' => $payload['country'],
                'notes' => $payload['notes'] ?? null,
                'subtotal' => $cartItems->sum('line_total'),
                'total' => $cartItems->sum('line_total'),
                'status' => 'processing',
            ]);

            foreach ($cartItems as $item) {
                /** @var Product $product */
                $product = $products->get($item['product']->id);
                $lineTotal = round((float) $product->price * $item['quantity'], 2);

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_image' => $product->image,
                    'unit_price' => $product->price,
                    'quantity' => $item['quantity'],
                    'line_total' => $lineTotal,
                ]);

                $product->decrement('quantity', $item['quantity']);
            }

            $cartService->clear();

            return $order;
        });

        session()->put('checkout.last_order', $order->order_number);

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order): View
    {
        $lastOrderNumber = session('checkout.last_order');
        $user = request()->user();

        $isAuthorized = $lastOrderNumber === $order->order_number
            || ($user && ($user->is_admin || $user->id === $order->user_id));

        abort_unless($isAuthorized, 403);

        $order->load('items.product');

        return view('checkout.success', compact('order'));
    }

    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'RLS-'.now()->format('Ymd').'-'.str_pad((string) random_int(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (Order::query()->where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
