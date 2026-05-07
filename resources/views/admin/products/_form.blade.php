@csrf

<div class="field">
    <label for="name">{{ __('ui.common.name') }}</label>
    <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required>
</div>

<div class="field">
    <label for="category_id">{{ __('ui.common.category') }}</label>
    <select id="category_id" name="category_id" required>
        <option value="">{{ __('ui.fields.choose_child_category') }}</option>
        @foreach ($categoryOptions as $categoryOption)
            <option value="{{ $categoryOption->id }}" @selected(old('category_id', $product->category_id) == $categoryOption->id)>
                {{ $categoryOption->parent ? $categoryOption->parent->localized_name.' / '.$categoryOption->localized_name : $categoryOption->localized_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="split-grid">
    <div class="field">
        <label for="price">{{ __('ui.common.price') }} (Dhs)</label>
        <input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
    </div>
    <div class="field">
        <label for="quantity">{{ __('ui.common.quantity') }}</label>
        <input id="quantity" type="number" name="quantity" value="{{ old('quantity', $product->quantity ?? 0) }}" min="0" required>
    </div>
</div>

<div class="field">
    <label for="description">{{ __('ui.common.description') }}</label>
    <textarea id="description" name="description" required>{{ old('description', $product->description) }}</textarea>
</div>

<div class="field">
    <label for="image">{{ __('ui.common.image') }}</label>
    <input id="image" type="file" name="image" accept="image/*">
    @if ($product->image)
        <img src="{{ $product->image_url }}" alt="{{ $product->localized_name }}" style="width: 120px; border-radius: 8px; margin-top: 0.75rem;">
    @endif
</div>

<div class="checkbox-row">
    <input type="hidden" name="featured" value="0">
    <input id="featured" type="checkbox" name="featured" value="1" @checked((int) old('featured', (int) ($product->featured ?? false)) === 1)>
    <label for="featured">{{ __('ui.fields.featured_product') }}</label>
</div>

<div class="checkbox-row">
    <input type="hidden" name="is_active" value="0">
    <input id="is_active" type="checkbox" name="is_active" value="1" @checked((int) old('is_active', $product->exists ? (int) $product->is_active : 1) === 1)>
    <label for="is_active">{{ __('ui.common.active') }}</label>
</div>

<div class="split-actions">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">{{ __('ui.common.cancel') }}</a>
</div>
