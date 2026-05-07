<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Lang;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('name');
    }

    public function scopeRoots(Builder $query): void
    {
        $query->whereNull('parent_id');
    }

    public function scopeVisible(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isRoot(): bool
    {
        return $this->parent_id === null;
    }

    public function familyIds(): array
    {
        $childIds = $this->relationLoaded('children')
            ? $this->children->pluck('id')
            : $this->children()->pluck('id');

        return $childIds->prepend($this->id)->all();
    }

    public function breadcrumbName(): string
    {
        return $this->parent
            ? "{$this->parent->localized_name} / {$this->localized_name}"
            : $this->localized_name;
    }

    public function getLocalizedNameAttribute(): string
    {
        $key = "catalog.categories.{$this->slug}.name";

        return Lang::has($key) ? (string) __($key) : $this->name;
    }

    public function getLocalizedDescriptionAttribute(): string
    {
        $key = "catalog.categories.{$this->slug}.description";

        return Lang::has($key) ? (string) __($key) : (string) $this->description;
    }

    public function getVisualAssetAttribute(): string
    {
        $assetPath = config("rilas.category_visuals.{$this->slug}", 'assets/categories/default.svg');

        return asset($assetPath);
    }
}
