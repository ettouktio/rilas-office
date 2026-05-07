<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view): void {
            $navigationCategories = collect();

            try {
                if (Schema::hasTable('categories')) {
                    $navigationCategories = Category::query()
                        ->roots()
                        ->visible()
                        ->with([
                            'children' => fn ($query) => $query->visible(),
                        ])
                        ->orderBy('sort_order')
                        ->orderBy('name')
                        ->get();
                }
            } catch (\Throwable) {
                $navigationCategories = collect();
            }

            $cartItems = session()->get('cart.items', []);

            $view->with([
                'navigationCategories' => $navigationCategories,
                'cartItemCount' => array_sum($cartItems),
                'supportedLocales' => config('rilas.supported_locales', []),
                'featuredCities' => config('rilas.featured_cities', []),
            ]);
        });
    }
}
