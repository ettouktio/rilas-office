<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function home(): View
    {
        $categoryTree = Category::query()
            ->roots()
            ->visible()
            ->withCount('products')
            ->with([
                'children' => fn ($query) => $query->visible()->withCount('products'),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $featuredProducts = Product::query()
            ->active()
            ->with('category.parent')
            ->orderByDesc('featured')
            ->latest()
            ->take(8)
            ->get();

        return view('storefront.home', compact('categoryTree', 'featuredProducts'));
    }

    public function shop(Request $request): View
    {
        $selectedCategory = null;
        $search = trim((string) $request->string('q'));
        $sort = (string) $request->string('sort', 'latest');

        $shopCategories = Category::query()
            ->roots()
            ->visible()
            ->with([
                'children' => fn ($query) => $query->visible()->withCount('products'),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $productsQuery = Product::query()
            ->active()
            ->with('category.parent');

        if ($categorySlug = (string) $request->string('category')) {
            $selectedCategory = Category::query()
                ->with('children')
                ->where('slug', $categorySlug)
                ->firstOrFail();

            $productsQuery->whereIn('category_id', $selectedCategory->familyIds());
        }

        if ($search !== '') {
            $productsQuery->where(function ($query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        match ($sort) {
            'price_asc' => $productsQuery->orderBy('price'),
            'price_desc' => $productsQuery->orderByDesc('price'),
            'name_asc' => $productsQuery->orderBy('name'),
            default => $productsQuery->latest(),
        };

        $products = $productsQuery->simplePaginate(12)->withQueryString();

        return view('storefront.shop', compact('products', 'shopCategories', 'selectedCategory', 'search', 'sort'));
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $relatedProducts = Product::query()
            ->active()
            ->with('category.parent')
            ->whereKeyNot($product->id)
            ->where('category_id', $product->category_id)
            ->take(4)
            ->get();

        return view('storefront.product', compact('product', 'relatedProducts'));
    }
}
