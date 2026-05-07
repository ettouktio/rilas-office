<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    private const SESSION_KEY = 'cart.items';

    public function items(): array
    {
        return session()->get(self::SESSION_KEY, []);
    }

    public function count(): int
    {
        return array_sum($this->items());
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function content(): Collection
    {
        $items = $this->items();

        if ($items === []) {
            return collect();
        }

        $products = Product::query()
            ->with('category.parent')
            ->whereIn('id', array_keys($items))
            ->get()
            ->keyBy('id');

        return collect($items)
            ->map(function (int $quantity, int|string $productId) use ($products) {
                $product = $products->get((int) $productId);

                if (! $product) {
                    return null;
                }

                $safeQuantity = min($quantity, max(0, $product->quantity));

                if ($safeQuantity < 1 || ! $product->is_active) {
                    return null;
                }

                return [
                    'product' => $product,
                    'quantity' => $safeQuantity,
                    'line_total' => round((float) $product->price * $safeQuantity, 2),
                ];
            })
            ->filter()
            ->values();
    }

    public function subtotal(): float
    {
        return (float) $this->content()->sum('line_total');
    }

    public function add(Product $product, int $quantity = 1): void
    {
        if ($quantity < 1) {
            return;
        }

        $items = $this->items();
        $current = (int) ($items[$product->getKey()] ?? 0);
        $items[$product->getKey()] = min($product->quantity, $current + $quantity);

        $this->store($items);
    }

    public function update(Product $product, int $quantity): void
    {
        $items = $this->items();

        if ($quantity <= 0) {
            unset($items[$product->getKey()]);
        } else {
            $items[$product->getKey()] = min($product->quantity, $quantity);
        }

        $this->store($items);
    }

    public function remove(Product $product): void
    {
        $items = $this->items();
        unset($items[$product->getKey()]);

        $this->store($items);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    private function store(array $items): void
    {
        session()->put(
            self::SESSION_KEY,
            array_filter($items, fn (int $quantity) => $quantity > 0)
        );
    }
}
