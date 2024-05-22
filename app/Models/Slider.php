<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = ['banner', 'type', 'description', 'starting_price', 'btn_url', 'serial', 'is_visible'];

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
}
