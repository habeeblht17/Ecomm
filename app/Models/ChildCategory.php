<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChildCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'sub_category_id', 'name', 'slug', 'is_visible',
    ];


    /**
     * category
     *
     * @return BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
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
     * products
     *
     * @return HasMany
     */
    public function products() : HasMany
    {
        return $this->hasMany(Product::class);
    }
}
