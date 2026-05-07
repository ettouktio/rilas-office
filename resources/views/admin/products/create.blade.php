@extends('layouts.admin')

@section('title', __('ui.admin.create_product_title'))

@section('admin_content')
    <div class="panel" style="padding: 1.5rem;">
        <h1 class="page-title">{{ __('ui.admin.create_product_heading') }}</h1>
        <p class="section-subtitle">{{ __('ui.admin.create_product_text') }}</p>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="stack-form">
            @include('admin.products._form', ['submitLabel' => __('ui.admin.create_product_button')])
        </form>
    </div>
@endsection
