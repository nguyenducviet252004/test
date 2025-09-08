<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes; // Add this line
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes; // Add SoftDeletes here
    protected $fillable = [
        'name',
        'slug',
        'img_thumb',
        'description',
        'category_id',
        'view',
        'is_active',
        'deleted_at',
        'created_at',
        'updated_at',
        'sell_quantity', // Cho phép cập nhật số lượng đã bán
    ];

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_reviews', 1);
    }

    /**
     * Relationship with ProductVariant
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get available variants (quantity > 0)
     */
    public function availableVariants()
    {
        return $this->hasMany(ProductVariant::class)->where('quantity', '>', 0);
    }

    /**
     * Get all sizes available for this product through variants
     */
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_variants', 'product_id', 'size_id')
                   ->distinct();
    }

    /**
     * Get all colors available for this product through variants
     */
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_variants', 'product_id', 'color_id')
                   ->distinct();
    }

    /**
     * Get minimum price from all variants
     */
    public function getMinPriceAttribute()
    {
        return $this->variants()->min('price') ?? 0;
    }

    /**
     * Get maximum price from all variants
     */
    public function getMaxPriceAttribute()
    {
        return $this->variants()->max('price') ?? 0;
    }

    /**
     * Get total quantity from all variants
     */
    public function getTotalQuantityAttribute()
    {
        return $this->variants()->sum('quantity') ?? 0;
    }
}
