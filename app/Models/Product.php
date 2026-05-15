<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Lang;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'quantity',
        'is_active',
        'featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
            'featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return '/assets/placeholder-product.svg';
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return '/'.ltrim($this->image, '/');
    }

    public function getCategoryTrailAttribute(): string
    {
        if (! $this->category) {
            return __('ui.shop.all_categories');
        }

        return $this->category->parent
            ? "{$this->category->parent->localized_name} / {$this->category->localized_name}"
            : $this->category->localized_name;
    }

    public function getLocalizedNameAttribute(): string
    {
        $key = "catalog.products.{$this->slug}.name";

        return Lang::has($key) ? (string) __($key) : $this->name;
    }

    public function getLocalizedDescriptionAttribute(): string
    {
        $key = "catalog.products.{$this->slug}.description";

        return Lang::has($key) ? (string) __($key) : $this->description;
    }
}
