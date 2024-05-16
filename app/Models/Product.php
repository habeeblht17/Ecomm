<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id', 'name', 'slug', 'short_description', 'description', 'price',
        'sku', 'stock', 'type', 'quantity', 'is_visible', 'is_featured', 'image', 'published_at',
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
     * brand
     *
     * @return BelongsTo
     */
    public function brand() : BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }


    /**
     * categories
     *
     * @return BelongsToMany
     */
    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

}
