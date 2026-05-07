@extends('layouts.admin')

@section('title', __('ui.admin.order_title', ['number' => $order->order_number]))

@section('admin_content')
    <div class="toolbar">
        <div>
            <h1 class="page-title">{{ $order->order_number }}</h1>
            <p class="section-subtitle">{{ $order->customer_name }} · {{ $order->email }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">{{ __('ui.checkout.back_to_orders') }}</a>
    </div>

    <div class="split-grid">
        <div class="panel" style="padding: 1.5rem;">
            <h2 class="section-title">{{ __('ui.checkout.shipping') }}</h2>
            <ul class="detail-list">
                <li>{{ $order->address }}</li>
                <li>{{ $order->city }}, {{ $order->postal_code }}</li>
                <li>{{ $order->country }}</li>
                <li>{{ $order->phone ?: __('ui.checkout.no_phone') }}</li>
                <li>{{ __('ui.common.status') }}: {{ __('ui.common.processing') }}</li>
            </ul>
        </div>

        <div class="summary-card">
            <h2 class="section-title">{{ __('ui.common.summary') }}</h2>
            <div class="summary-row">
                <span>{{ __('ui.common.subtotal') }}</span>
                <span>{{ number_format((float) $order->subtotal, 2, ',', ' ') }} Dhs</span>
            </div>
            <div class="summary-row total">
                <span>{{ __('ui.common.total') }}</span>
                <span>{{ number_format((float) $order->total, 2, ',', ' ') }} Dhs</span>
            </div>
        </div>
    </div>

    <div class="section-tight"></div>

    <div class="table-panel">
        <table>
            <thead>
                <tr>
                    <th>{{ __('ui.common.product') }}</th>
                    <th>{{ __('ui.common.quantity') }}</th>
                    <th>{{ __('ui.admin.unit_price') }}</th>
                    <th>{{ __('ui.admin.line_total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->display_product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format((float) $item->unit_price, 2, ',', ' ') }} Dhs</td>
                        <td>{{ number_format((float) $item->line_total, 2, ',', ' ') }} Dhs</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
