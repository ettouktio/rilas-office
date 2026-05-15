<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

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
        // 🔥 Force HTTPS (important for Railway)
        $host = request()->getHost();

        if (app()->environment('production') && ! in_array($host, ['127.0.0.1', 'localhost'], true)) {
            URL::forceScheme('https');
        }

        // 🌐 Share global view data
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
            } catch (\Throwable $e) {
                $navigationCategories = collect();
            }

            $cartItems = session()->get('cart.items', []);

            $view->with([
                'navigationCategories' => $navigationCategories,
                'cartItemCount' => is_array($cartItems) ? array_sum($cartItems) : 0,
                'supportedLocales' => config('rilas.supported_locales', []),
                'featuredCities' => config('rilas.featured_cities', []),
            ]);
        });
    }
}
