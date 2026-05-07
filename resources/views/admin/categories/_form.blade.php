@csrf

<div class="field">
    <label for="name">{{ __('ui.common.name') }}</label>
    <input id="name" type="text" name="name" value="{{ old('name', $category->name) }}" required>
</div>

<div class="field">
    <label for="parent_id">{{ __('ui.fields.parent_category') }}</label>
    <select id="parent_id" name="parent_id">
        <option value="">{{ __('ui.fields.top_level_category') }}</option>
        @foreach ($parentOptions as $parentOption)
            <option value="{{ $parentOption->id }}" @selected(old('parent_id', $category->parent_id) == $parentOption->id)>{{ $parentOption->localized_name }}</option>
        @endforeach
    </select>
</div>

<div class="field">
    <label for="sort_order">{{ __('ui.fields.sort_order') }}</label>
    <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0">
</div>

<div class="field">
    <label for="description">{{ __('ui.common.description') }}</label>
    <textarea id="description" name="description">{{ old('description', $category->description) }}</textarea>
</div>

<div class="checkbox-row">
    <input type="hidden" name="is_active" value="0">
    <input id="is_active" type="checkbox" name="is_active" value="1" @checked((int) old('is_active', $category->exists ? (int) $category->is_active : 1) === 1)>
    <label for="is_active">{{ __('ui.common.active') }}</label>
</div>

<div class="split-actions">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">{{ __('ui.common.cancel') }}</a>
</div>
