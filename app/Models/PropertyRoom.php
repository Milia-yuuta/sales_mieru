<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PropertyRoom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'property_id', 'prospect_id', 'room_name', 'client_id','created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function prospect()
    {
        return $this->belongsTo(Prospect::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
