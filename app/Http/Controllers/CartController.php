<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(CartService $cartService): View
    {
        return view('cart.index', [
            'cartItems' => $cartService->content(),
            'subtotal' => $cartService->subtotal(),
        ]);
    }

    public function store(Request $request, Product $product, CartService $cartService): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        if (! $product->is_active || $product->quantity < 1) {
            return back()->with('error', __('ui.flash.product_out_of_stock'));
        }

        $cartService->add($product, min($validated['quantity'] ?? 1, $product->quantity));

        return back()->with('success', __('ui.flash.added_to_cart', ['product' => $product->localized_name]));
    }

    public function update(Request $request, Product $product, CartService $cartService): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        if ($validated['quantity'] > $product->quantity) {
            return back()->with('error', __('ui.flash.quantity_too_high'));
        }

        $cartService->update($product, $validated['quantity']);

        return back()->with('success', __('ui.flash.cart_updated'));
    }

    public function destroy(Product $product, CartService $cartService): RedirectResponse
    {
        $cartService->remove($product);

        return back()->with('success', __('ui.flash.product_removed'));
    }
}
