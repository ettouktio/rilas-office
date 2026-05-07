@extends('layouts.admin')

@section('title', __('ui.admin.orders_title'))

@section('admin_content')
    <div class="toolbar">
        <div>
            <h1 class="page-title">{{ __('ui.admin.orders_heading') }}</h1>
            <p class="section-subtitle">{{ __('ui.admin.orders_text') }}</p>
        </div>
    </div>

    <div class="table-panel">
        <table>
            <thead>
                <tr>
                    <th>{{ __('ui.admin.order') }}</th>
                    <th>{{ __('ui.admin.customer') }}</th>
                    <th>{{ __('ui.common.status') }}</th>
                    <th>{{ __('ui.common.total') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ __('ui.common.processing') }}</td>
                        <td>{{ number_format((float) $order->total, 2, ',', ' ') }} Dhs</td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-ghost">{{ __('ui.common.view') }}</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="muted">{{ __('ui.admin.no_orders') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('partials.pager', ['paginator' => $orders])
@endsection
