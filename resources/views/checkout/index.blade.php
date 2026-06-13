@extends('layouts.app')

@section('title', __('ui.checkout.title'))

@section('content')
    <section class="section">
        <div class="container checkout-layout">
            <div class="panel" style="padding: 1.25rem;">
                <h1 class="page-title">{{ __('ui.checkout.page_title') }}</h1>
                <p class="section-subtitle">{{ __('ui.checkout.subtitle') }}</p>

                <form action="{{ route('checkout.store') }}" method="POST" class="stack-form">
                    @csrf

                    <div class="split-grid">
                        <div class="field">
                            <label for="first_name">{{ __('ui.fields.first_name') }}</label>
                            <input id="first_name" type="text" name="first_name" value="{{ old('first_name', $user?->name ? explode(' ', $user->name)[0] : '') }}" required>
                        </div>
                        <div class="field">
                            <label for="last_name">{{ __('ui.fields.last_name') }}</label>
                            <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required>
                        </div>
                    </div>

                    <div class="field">
                        <label for="email">{{ __('ui.fields.email') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $user?->email) }}" required>
                    </div>

                    <div class="field">
                        <label for="phone">{{ __('ui.fields.phone') }}</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}">
                    </div>

                    <div class="field">
                        <label for="address">{{ __('ui.fields.address') }}</label>
                        <input id="address" type="text" name="address" value="{{ old('address') }}" required>
                    </div>

                    <div class="split-grid">
                        <div class="field">
                            <label for="city">{{ __('ui.fields.city') }}</label>
                            <input id="city" type="text" name="city" value="{{ old('city') }}" required>
                        </div>
                        <div class="field">
                            <label for="postal_code">{{ __('ui.fields.postal_code') }}</label>
                            <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code') }}" required>
                        </div>
                    </div>

                    <div class="field">
                        <label for="country">{{ __('ui.fields.country') }}</label>
                        <input id="country" type="text" name="country" value="{{ old('country', 'Morocco') }}" required>
                    </div>

                    <div class="field">
                        <label for="notes">{{ __('ui.fields.notes') }}</label>
                        <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">{{ __('ui.checkout.place_order') }}</button>
                </form>
            </div>

            <aside class="summary-card">
                <h2 class="section-title">{{ __('ui.checkout.summary') }}</h2>
                <ul class="stack-list">
                    @foreach ($cartItems as $item)
                        <li class="line-item">
                            <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->localized_name }}">
                            <div>
                                <strong>{{ $item['product']->localized_name }}</strong>
                                <div class="muted">{{ __('ui.checkout.qty', ['count' => $item['quantity']]) }}</div>
                                <div class="price">{{ number_format($item['line_total'], 2, ',', ' ') }} Dhs</div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="summary-row total">
                    <span>{{ __('ui.common.total') }}</span>
                    <span>{{ number_format($subtotal, 2, ',', ' ') }} Dhs</span>
                </div>
            </aside>
        </div>
    </section>
@endsection
