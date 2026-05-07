@extends('layouts.admin')

@section('title', __('ui.admin.create_category_title'))

@section('admin_content')
    <div class="panel" style="padding: 1.5rem;">
        <h1 class="page-title">{{ __('ui.admin.create_category_heading') }}</h1>
        <p class="section-subtitle">{{ __('ui.admin.create_category_text') }}</p>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="stack-form">
            @include('admin.categories._form', ['submitLabel' => __('ui.admin.create_category_button')])
        </form>
    </div>
@endsection
