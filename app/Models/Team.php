<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'user_id2', 'created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];
    /*
   |--------------------------------------------------------------------------
   | Relations
   |--------------------------------------------------------------------------
   */

    public function sale(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'sales_id');
    }

    public function hat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'hat_id');
    }

    public function office(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserMaster::class, 'office_master_id');
    }

    public function area(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ActionMaster::class, 'area_master_id');
    }
}
