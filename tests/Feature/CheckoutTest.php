<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_creates_an_order_and_decrements_stock(): void
    {
        $root = Category::create([
            'name' => 'Root Category',
            'slug' => 'root-category',
            'sort_order' => 0,
            'is_active' => true,
        ]);

        $child = Category::create([
            'name' => 'Child Category',
            'slug' => 'root-category-child-category',
            'parent_id' => $root->id,
            'sort_order' => 0,
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'Checkout Product',
            'slug' => 'checkout-product',
            'category_id' => $child->id,
            'description' => 'Checkout test product.',
            'price' => 99.99,
            'quantity' => 5,
            'is_active' => true,
            'featured' => false,
        ]);

        $response = $this
            ->withSession(['cart.items' => [$product->id => 2]])
            ->post('/checkout', [
                'first_name' => 'Test',
                'last_name' => 'Buyer',
                'email' => 'buyer@example.com',
                'phone' => '0600000000',
                'address' => '123 Test Street',
                'city' => 'Casablanca',
                'postal_code' => '20000',
                'country' => 'Morocco',
                'notes' => 'Leave at reception',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'email' => 'buyer@example.com',
            'city' => 'Casablanca',
            'status' => 'processing',
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'quantity' => 3,
        ]);
    }
}
