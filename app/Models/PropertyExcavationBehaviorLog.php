<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyExcavationBehaviorLog extends Model
{
    protected $fillable = [
        'user_id', 'action_date', 'property_id',
        'manager_visit_count', 'check_building_count', 'manager_TEL_count',
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

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
