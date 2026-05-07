@extends('layouts.admin')

@section('title', __('ui.admin.categories_title'))

@section('admin_content')
    <div class="toolbar">
        <div>
            <h1 class="page-title">{{ __('ui.admin.categories_heading') }}</h1>
            <p class="section-subtitle">{{ __('ui.admin.categories_text') }}</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">{{ __('ui.admin.new_category') }}</a>
    </div>

    <div class="table-panel">
        <table>
            <thead>
                <tr>
                    <th>{{ __('ui.common.name') }}</th>
                    <th>{{ __('ui.common.category') }}</th>
                    <th>{{ __('ui.admin.children_products') }}</th>
                    <th>{{ __('ui.common.status') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rootCategories as $category)
                    <tr>
                        <td>{{ $category->localized_name }}</td>
                        <td>{{ __('ui.common.parent') }}</td>
                        <td>{{ __('ui.admin.children_count', ['count' => $category->children->count(), 'products' => $category->products_count]) }}</td>
                        <td>{{ $category->is_active ? __('ui.common.active') : __('ui.common.hidden') }}</td>
                        <td class="cell-actions">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-ghost">{{ __('ui.common.edit') }}</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost">{{ __('ui.common.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                    @foreach ($category->children as $child)
                        <tr>
                            <td>- {{ $child->localized_name }}</td>
                            <td>{{ __('ui.common.child') }}</td>
                            <td>{{ __('ui.admin.child_products_count', ['count' => $child->products_count]) }}</td>
                            <td>{{ $child->is_active ? __('ui.common.active') : __('ui.common.hidden') }}</td>
                            <td class="cell-actions">
                                <a href="{{ route('admin.categories.edit', $child) }}" class="btn btn-ghost">{{ __('ui.common.edit') }}</a>
                                <form action="{{ route('admin.categories.destroy', $child) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost">{{ __('ui.common.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
