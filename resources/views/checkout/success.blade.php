@extends('layouts.app')

@section('title', __('ui.checkout.success_title'))

@section('content')
    <section class="section">
        <div class="container">
            <div class="success-card">
                <span class="eyebrow">{{ __('ui.checkout.success_eyebrow') }}</span>
                <h1 class="page-title">{{ __('ui.checkout.success_heading') }}</h1>
                <p class="muted">{{ __('ui.checkout.reference') }} <strong>{{ $order->order_number }}</strong></p>
                <p class="muted">{{ $order->customer_name }} · {{ $order->email }}</p>
                <p class="muted">{{ $order->address }}, {{ $order->city }}, {{ $order->country }}</p>
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
        </div>
    </section>
@endsection
