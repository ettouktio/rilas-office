@extends('layouts.app')

@section('title', __('ui.cart.title'))

@section('content')
    <section class="section">
        <div class="container">
            <div class="toolbar">
                <div>
                    <h1 class="page-title">{{ __('ui.cart.page_title') }}</h1>
                    <p class="section-subtitle">{{ __('ui.cart.subtitle') }}</p>
                </div>
            </div>

            @if ($cartItems->isEmpty())
                <div class="empty-state">
                    <h2>{{ __('ui.cart.empty_title') }}</h2>
                    <p class="muted">{{ __('ui.cart.empty_text') }}</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">{{ __('ui.cart.go_shop') }}</a>
                </div>
            @else
                <div class="cart-layout">
                    <div class="table-panel">
                        <table>
                            <thead>
                                <tr>
                                    <th>{{ __('ui.common.product') }}</th>
                                    <th>{{ __('ui.common.quantity') }}</th>
                                    <th>{{ __('ui.cart.line_total') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td>
                                            <div class="line-item">
                                                <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->localized_name }}">
                                                <div>
                                                    <strong>{{ $item['product']->localized_name }}</strong>
                                                    <div class="muted">{{ $item['product']->category_trail }}</div>
                                                    <div class="muted">{{ number_format((float) $item['product']->price, 2, ',', ' ') }} Dhs / {{ __('ui.cart.unit') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ route('cart.update', $item['product']) }}" method="POST" class="split-actions">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="0" max="{{ $item['product']->quantity }}" style="width: 84px;">
                                                <button type="submit" class="btn btn-ghost">{{ __('ui.cart.update') }}</button>
                                            </form>
                                        </td>
                                        <td class="price">{{ number_format($item['line_total'], 2, ',', ' ') }} Dhs</td>
                                        <td>
                                            <form action="{{ route('cart.destroy', $item['product']) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-ghost">{{ __('ui.cart.remove') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <aside class="summary-card">
                        <h2 class="section-title">{{ __('ui.common.summary') }}</h2>
                        <div class="summary-row">
                            <span>{{ __('ui.common.items') }}</span>
                            <span>{{ $cartItems->sum('quantity') }}</span>
                        </div>
                        <div class="summary-row total">
                            <span>{{ __('ui.common.total') }}</span>
                            <span>{{ number_format($subtotal, 2, ',', ' ') }} Dhs</span>
                        </div>
                        <div class="summary-actions" style="margin-top: 1rem;">
                            <a href="{{ route('checkout.create') }}" class="btn btn-primary btn-block">{{ __('ui.cart.proceed') }}</a>
                            <a href="{{ route('shop') }}" class="btn btn-ghost btn-block">{{ __('ui.cart.continue') }}</a>
                        </div>
                    </aside>
                </div>
            @endif
        </div>
    </section>
@endsection
