<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'sku', 'price', 'quantity', 'stock'
    ];

    /**
     * product
     *
     * @return BelongsTo
     */
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // /**
    //  * attributes
    //  *
    //  * @return BelongsToMany
    //  */
    // public function attributes() : BelongsToMany
    // {
    //     return $this->belongsToMany(Attribute::class, 'variant_attributes')
    //                 ->withPivot('attribute_value_id')
    //                 ->withTimestamps();
    // }

    public function attributes()
    {
        return $this->hasMany(VariantAttribute::class);
    }
}
