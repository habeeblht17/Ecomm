<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id', 'vendor_id', 'category_id', 'sub_category_id', 'child_category_id', 'name', 'slug', 'short_description', 'description', 'price',
        'sku', 'stock', 'type', 'quantity', 'is_visible', 'is_featured', 'is_approved', 'image', 'published_at',
    ];

    /**
     * scopeVisible
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeVisible($query)
    {
        $query->where('is_visible', true);
    }


    /**
     * scopeFeatured
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeFeatured($query)
    {
        $query->where('is_featured', true);
    }


    /**
     * scopePublished
     *
     * @param  mixed $query
     * @return void
     */
    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    /**
     * galleries
     *
     * @return HasMany
     */
    public function galleries() : HasMany
    {
        return $this->hasMany(ProductGallery::class);
    }


    /**
     * brand
     *
     * @return BelongsTo
     */
    public function brand() : BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * vendor
     *
     * @return BelongsTo
     */
    public function vendor() : BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * categories
     *
     * @return BelongsToMany
     */
    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * subCategory
     *
     * @return BelongsTo
     */
    public function subCategory() : BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * childCategory
     *
     * @return BelongsTo
     */
    public function childCategory() : BelongsTo
    {
        return $this->belongsTo(ChildCategory::class);
    }

}
