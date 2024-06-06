<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariantAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['variant_id', 'attribute_id', 'attribute_value_id'];

    /**
     * variant
     *
     * @return BelongsTo
     */
    public function variant() : BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }

    /**
     * attribute
     *
     * @return BelongsTo
     */
    public function attribute() : BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * attributeValue
     *
     * @return BelongsTo
     */
    public function attributeValue() : BelongsTo
    {
        return $this->belongsTo(AttributeValue::class);
    }
}
