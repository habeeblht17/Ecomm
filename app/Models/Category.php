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
        'parent_id', 'name', 'slug', 'description', 'is_visible', 'image',
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
     * parent
     *
     * @return BelongsTo
     */
    public function parent() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }


    /**
     * child
     *
     * @return HasMany
     */
    public function child() : HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
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
