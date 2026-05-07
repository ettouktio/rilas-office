<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_image',
        'unit_price',
        'quantity',
        'line_total',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'line_total' => 'decimal:2',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->product_image) {
            if (str_starts_with($this->product_image, 'http://') || str_starts_with($this->product_image, 'https://')) {
                return $this->product_image;
            }

            return asset(ltrim($this->product_image, '/'));
        }

        return $this->product?->image_url ?? asset('assets/placeholder-product.svg');
    }

    public function getDisplayProductNameAttribute(): string
    {
        return $this->product?->localized_name ?? $this->product_name;
    }
}
