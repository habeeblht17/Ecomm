<?php

namespace App\Models;

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

    public function brand() : BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }
}
