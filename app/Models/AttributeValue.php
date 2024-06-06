<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'value'];

    /**
     * attribute
     *
     * @return BelongsTo
     */
    public function attribute() : BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}
