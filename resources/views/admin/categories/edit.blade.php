@extends('layouts.admin')

@section('title', __('ui.admin.edit_category_title'))

@section('admin_content')
    <div class="panel" style="padding: 1.5rem;">
        <h1 class="page-title">{{ __('ui.admin.edit_category_heading') }}</h1>
        <p class="section-subtitle">{{ __('ui.admin.edit_category_text') }}</p>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="stack-form">
            @method('PUT')
            @include('admin.categories._form', ['submitLabel' => __('ui.common.save_changes')])
        </form>
    </div>
@endsection
