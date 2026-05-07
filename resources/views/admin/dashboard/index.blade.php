@extends('layouts.admin')

@section('title', __('ui.admin.dashboard_title'))

@section('admin_content')
    <div class="toolbar">
        <div>
            <h1 class="page-title">{{ __('ui.admin.dashboard_heading') }}</h1>
            <p class="section-subtitle">{{ __('ui.admin.dashboard_text') }}</p>
        </div>
    </div>

    <div class="stats-grid">
        <article class="stats-card">
            <strong>{{ $stats['products'] }}</strong>
            <span class="muted">{{ __('ui.admin.products') }}</span>
        </article>
        <article class="stats-card">
            <strong>{{ $stats['categories'] }}</strong>
            <span class="muted">{{ __('ui.admin.categories') }}</span>
        </article>
        <article class="stats-card">
            <strong>{{ $stats['orders'] }}</strong>
            <span class="muted">{{ __('ui.admin.orders') }}</span>
        </article>
        <article class="stats-card">
            <strong>{{ $stats['low_stock'] }}</strong>
            <span class="muted">{{ __('ui.admin.low_stock_products') }}</span>
        </article>
    </div>

    <div class="section-tight"></div>

    <div class="split-grid">
        <div class="table-panel">
            <table>
                <thead>
                    <tr>
                        <th colspan="3">{{ __('ui.admin.recent_orders') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-ghost">{{ __('ui.common.view') }}</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="muted">{{ __('ui.admin.no_orders') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-panel">
            <table>
                <thead>
                    <tr>
                        <th colspan="3">{{ __('ui.admin.low_stock_products') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowStockProducts as $product)
                        <tr>
                            <td>{{ $product->localized_name }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td><a href="{{ route('admin.products.edit', $product) }}" class="btn btn-ghost">{{ __('ui.admin.restock') }}</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="muted">{{ __('ui.admin.all_good') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
