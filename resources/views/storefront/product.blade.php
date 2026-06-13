@extends('layouts.app')

@section('title', __('ui.product.title_prefix').$product->localized_name)

@section('content')
    <section class="section">
        <div class="container detail-layout">
            <div class="panel">
                <img src="{{ $product->image_url }}" alt="{{ $product->localized_name }}" class="detail-image">
            </div>

            <div class="detail-copy panel" style="padding: 1.25rem;">
                <span class="eyebrow">{{ $product->category_trail }}</span>
                <h1>{{ $product->localized_name }}</h1>
                <p class="product-description-text">{{ $product->localized_description }}</p>

                <div class="split-actions" style="margin: 1rem 0;">
                    <span class="price">{{ number_format((float) $product->price, 2, ',', ' ') }} Dhs</span>
                    @if ($product->quantity > 0)
                        <span class="badge">{{ __('ui.product.in_stock', ['count' => $product->quantity]) }}</span>
                    @else
                        <span class="badge badge-danger">{{ __('ui.product.out_of_stock') }}</span>
                    @endif
                </div>

                <form action="{{ route('cart.store', $product) }}" method="POST" class="stack-form">
                    @csrf
                    <div class="field">
                        <label for="quantity">{{ __('ui.product.quantity_label') }}</label>
                        <input id="quantity" type="number" name="quantity" value="1" min="1" max="{{ max(1, $product->quantity) }}">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" @disabled($product->quantity < 1)>{{ __('ui.common.add_to_cart') }}</button>
                </form>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="toolbar">
                <div>
                    <h2 class="section-title">{{ __('ui.product.related_title') }}</h2>
                    <p class="section-subtitle">{{ __('ui.product.related_text') }}</p>
                </div>
            </div>

            <div class="product-grid">
                @forelse ($relatedProducts as $relatedProduct)
                    <article class="product-card">
                        <a href="{{ route('products.show', $relatedProduct) }}">
                            <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->localized_name }}">
                        </a>
                        <div class="product-card-body">
                            <span class="muted">{{ $relatedProduct->category_trail }}</span>
                            <h3><a href="{{ route('products.show', $relatedProduct) }}">{{ $relatedProduct->localized_name }}</a></h3>
                            <div class="price-row">
                                <span class="price">{{ number_format((float) $relatedProduct->price, 2, ',', ' ') }} Dhs</span>
                                <a href="{{ route('products.show', $relatedProduct) }}" class="btn btn-ghost">{{ __('ui.common.view') }}</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">
                        <p class="muted">{{ __('ui.product.empty_related') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
