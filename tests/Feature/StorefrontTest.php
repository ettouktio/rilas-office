<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_and_shop_pages_render_with_seeded_like_content(): void
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

        Product::create([
            'name' => 'Testing Product',
            'slug' => 'testing-product',
            'category_id' => $child->id,
            'description' => 'Storefront test product.',
            'price' => 49.99,
            'quantity' => 10,
            'is_active' => true,
            'featured' => true,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('RILAS Office')
            ->assertSee('Root Category');

        $this->get('/shop')
            ->assertOk()
            ->assertSee('Testing Product')
            ->assertSee('Child Category');
    }

    public function test_locale_switch_changes_visible_ui_language(): void
    {
        $this->get('/locale/ar')
            ->assertRedirect();

        $this->withSession(['locale' => 'ar'])
            ->get('/shop')
            ->assertOk()
            ->assertSee('المتجر')
            ->assertSee('تطبيق الفلاتر');
    }
}
