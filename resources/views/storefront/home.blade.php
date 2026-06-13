@extends('layouts.app')

@section('title', __('ui.home.title'))

@section('content')
    <section class="section">
        <div class="container hero">
            <div class="hero-copy">
                <span class="eyebrow">{{ __('ui.home.eyebrow') }}</span>
                <h1 class="sr-only">{{ config('app.name', 'RILAS Office') }}</h1>
                <h2 class="hero-title">{{ __('ui.home.headline') }}</h2>
                <p>{{ __('ui.home.description') }}</p>
                <div class="hero-actions">
                    <a href="{{ route('shop') }}" class="btn btn-primary">{{ __('ui.common.browse_products') }}</a>
                    @auth
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">{{ __('ui.home.admin_panel') }}</a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="btn btn-outline">{{ __('ui.nav.register') }}</a>
                    @endauth
                </div>
                <div class="city-row">
                    <span class="hero-kpi">{{ __('ui.home.kpi_one') }}</span>
                    <span class="hero-kpi">{{ __('ui.home.kpi_two') }}</span>
                </div>
            </div>

            <div class="hero-visual">
                <img src="/assets/hero-rilas-morocco.svg" alt="{{ config('app.name', 'RILAS Office') }} Morocco office catalog">
            </div>
        </div>
    </section>

    <section class="section-tight">
        <div class="container feature-grid">
            <div class="feature-card">
                <strong>{{ __('ui.home.features.catalog_title') }}</strong>
                <span class="muted">{{ __('ui.home.features.catalog_text') }}</span>
            </div>
            <div class="feature-card">
                <strong>{{ __('ui.home.features.cart_title') }}</strong>
                <span class="muted">{{ __('ui.home.features.cart_text') }}</span>
            </div>
            <div class="feature-card">
                <strong>{{ __('ui.home.features.checkout_title') }}</strong>
                <span class="muted">{{ __('ui.home.features.checkout_text') }}</span>
            </div>
            <div class="feature-card">
                <strong>{{ __('ui.home.features.admin_title') }}</strong>
                <span class="muted">{{ __('ui.home.features.admin_text') }}</span>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="toolbar">
                <div>
                    <h2 class="section-title">{{ __('ui.home.category_tree_title') }}</h2>
                    <p class="section-subtitle">{{ __('ui.home.category_tree_subtitle') }}</p>
                </div>
            </div>

            <div class="category-grid">
                @foreach ($categoryTree as $category)
                    <article class="category-card">
                        <img src="{{ $category->visual_asset }}" alt="{{ $category->localized_name }}" class="category-visual">
                        <h3>{{ $category->localized_name }}</h3>
                        <p class="muted">{{ $category->localized_description }}</p>
                        <p class="muted">{{ __('ui.home.products_in_family', ['count' => $category->products_count + $category->children->sum('products_count')]) }}</p>

                        <ul class="category-list">
                            @foreach ($category->children as $child)
                                <li>
                                    <a href="{{ route('shop', ['category' => $child->slug]) }}">
                                        {{ $child->localized_name }} <span class="muted">({{ $child->products_count }})</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="toolbar">
                <div>
                    <h2 class="section-title">{{ __('ui.home.featured_title') }}</h2>
                    <p class="section-subtitle">{{ __('ui.home.featured_subtitle') }}</p>
                </div>
                <a href="{{ route('shop') }}" class="btn btn-ghost">{{ __('ui.common.view_all') }}</a>
            </div>

            <div class="product-grid">
                @foreach ($featuredProducts as $product)
                    <article class="product-card">
                        <a href="{{ route('products.show', $product) }}">
                            <img src="{{ $product->image_url }}" alt="{{ $product->localized_name }}">
                        </a>
                        <div class="product-card-body">
                            <span class="muted">{{ $product->category_trail }}</span>
                            <h3><a href="{{ route('products.show', $product) }}">{{ $product->localized_name }}</a></h3>
                            <div class="price-row">
                                <span class="price">{{ number_format((float) $product->price, 2, ',', ' ') }} Dhs</span>
                                <form action="{{ route('cart.store', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">{{ __('ui.common.add_to_cart') }}</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
