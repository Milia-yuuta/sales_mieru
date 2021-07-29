<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProspectFavorite extends Model
{
    protected $fillable = [
        'user_id','prospect_id',
        'created_at', 'updated_at'
    ];

    /*
   |--------------------------------------------------------------------------
   | Relations
   |--------------------------------------------------------------------------
   */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prospect()
    {
        return $this->belongsTo(Prospect::class);
    }
}
