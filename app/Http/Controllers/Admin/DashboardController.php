<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'products' => Product::query()->count(),
            'categories' => Category::query()->count(),
            'orders' => Order::query()->count(),
            'low_stock' => Product::query()->where('quantity', '<=', 5)->count(),
        ];

        $recentOrders = Order::query()
            ->latest()
            ->take(6)
            ->get();

        $lowStockProducts = Product::query()
            ->with('category.parent')
            ->where('quantity', '<=', 5)
            ->orderBy('quantity')
            ->take(6)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'recentOrders', 'lowStockProducts'));
    }
}
