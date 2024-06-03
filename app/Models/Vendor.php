<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'banner', 'logo', 'phone', 'email', 'address', 'description', 'is_approved',
        'is_featured', 'insta_link', 'fb_link', 'tw_link'
    ];

    /**
     * user
     *
     * @return void
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * product
     *
     * @return void
     */
    public function product() : HasMany
    {
        return $this->hasMany(Product::class);
    }
}
