@extends('layouts.admin')

@section('title', __('ui.admin.products_title'))

@section('admin_content')
    <div class="toolbar">
        <div>
            <h1 class="page-title">{{ __('ui.admin.products_heading') }}</h1>
            <p class="section-subtitle">{{ __('ui.admin.products_text') }}</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">{{ __('ui.admin.new_product') }}</a>
    </div>

    <div class="toolbar">
        <form action="{{ route('admin.products.index') }}" method="GET">
            <input type="text" name="q" value="{{ $search }}" placeholder="{{ __('ui.admin.search_products') }}">
            <button type="submit" class="btn btn-ghost">{{ __('ui.common.search') }}</button>
        </form>
    </div>

    <div class="table-panel">
        <table>
            <thead>
                <tr>
                    <th>{{ __('ui.common.product') }}</th>
                    <th>{{ __('ui.common.category') }}</th>
                    <th>{{ __('ui.common.price') }}</th>
                    <th>{{ __('ui.common.stock') }}</th>
                    <th>{{ __('ui.common.status') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <div class="line-item">
                                <img src="{{ $product->image_url }}" alt="{{ $product->localized_name }}">
                                <div>
                                    <strong>{{ $product->localized_name }}</strong>
                                    <div class="muted">{{ \Illuminate\Support\Str::limit($product->localized_description, 70) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $product->category_trail }}</td>
                        <td>{{ number_format((float) $product->price, 2, ',', ' ') }} Dhs</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->is_active ? __('ui.common.active') : __('ui.common.hidden') }}</td>
                        <td class="cell-actions">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-ghost">{{ __('ui.common.edit') }}</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost">{{ __('ui.common.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('partials.pager', ['paginator' => $products])
@endsection
