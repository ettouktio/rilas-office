@extends('layouts.app')

@section('title', __('ui.shop.title'))

@section('content')
    <section class="section">
        <div class="container">
            <div class="toolbar">
                <div>
                    <h1 class="page-title">{{ __('ui.shop.page_title') }}</h1>
                    <p class="section-subtitle">{{ __('ui.shop.subtitle') }}</p>
                </div>
            </div>

            <div class="shop-layout">
                <aside class="sidebar panel">
                    <form action="{{ route('shop') }}" method="GET" class="filter-form">
                        <div class="field">
                            <label for="q">{{ __('ui.shop.search_label') }}</label>
                            <input id="q" type="text" name="q" value="{{ $search }}" placeholder="{{ __('ui.shop.search_placeholder') }}">
                        </div>

                        <div class="field">
                            <label for="category">{{ __('ui.shop.category_label') }}</label>
                            <select id="category" name="category">
                                <option value="">{{ __('ui.shop.all_categories') }}</option>
                                @foreach ($shopCategories as $category)
                                    <option value="{{ $category->slug }}" @selected(optional($selectedCategory)->id === $category->id)>{{ $category->localized_name }}</option>
                                    @foreach ($category->children as $child)
                                        <option value="{{ $child->slug }}" @selected(optional($selectedCategory)->id === $child->id)>- {{ $child->localized_name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label for="sort">{{ __('ui.shop.sort_label') }}</label>
                            <select id="sort" name="sort">
                                <option value="latest" @selected($sort === 'latest')>{{ __('ui.shop.sort_latest') }}</option>
                                <option value="price_asc" @selected($sort === 'price_asc')>{{ __('ui.shop.sort_price_asc') }}</option>
                                <option value="price_desc" @selected($sort === 'price_desc')>{{ __('ui.shop.sort_price_desc') }}</option>
                                <option value="name_asc" @selected($sort === 'name_asc')>{{ __('ui.shop.sort_name_asc') }}</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">{{ __('ui.shop.apply_filters') }}</button>
                    </form>
                </aside>

                <div>
                    @if ($selectedCategory)
                        <div class="alert">
                            {{ __('ui.shop.viewing') }} <strong>{{ $selectedCategory->breadcrumbName() }}</strong>
                        </div>
                    @endif

                    @if ($products->count())
                        <div class="product-grid">
                            @foreach ($products as $product)
                                <article class="product-card">
                                    <a href="{{ route('products.show', $product) }}">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->localized_name }}">
                                    </a>
                                    <div class="product-card-body">
                                        <div class="product-meta">
                                            <span class="muted">{{ $product->category_trail }}</span>
                                            @if ($product->quantity <= 5)
                                                <span class="badge badge-danger">{{ __('ui.shop.low_stock') }}</span>
                                            @endif
                                        </div>
                                        <h3><a href="{{ route('products.show', $product) }}">{{ $product->localized_name }}</a></h3>
                                        <p class="product-card-description">{{ \Illuminate\Support\Str::limit($product->localized_description, 100) }}</p>
                                        <div class="price-row">
                                            <span class="price">{{ number_format((float) $product->price, 2, ',', ' ') }} Dhs</span>
                                            <form action="{{ route('cart.store', $product) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary" @disabled($product->quantity < 1)>{{ __('ui.common.add_to_cart') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        @include('partials.pager', ['paginator' => $products])
                    @else
                        <div class="empty-state">
                            <h2>{{ __('ui.shop.empty_title') }}</h2>
                            <p class="muted">{{ __('ui.shop.empty_text') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
