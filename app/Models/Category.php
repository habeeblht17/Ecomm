<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'is_visible', 'image',
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
     * subCategories
     *
     * @return HasMany
     */
    public function subCategories() : HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    /**
     * childCategories
     *
     * @return HasMany
     */
    public function childCategories() : HasMany
    {
        return $this->hasMany(ChildCategory::class);
    }

    /**
     * products
     *
     * @return BelongsToMany
     */
    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }


}
