<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyFavorite extends Model
{
    protected $fillable = [
        'user_id','property_id', 'created_at', 'updated_at'
    ];

    /*
   |--------------------------------------------------------------------------
   | Relations
   |--------------------------------------------------------------------------
   */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function property(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

}
