<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMaster extends Model
{
    protected $fillable = [
        'user_master_id', 'group_num', 'val', 'name', 'seq','created_at', 'updated_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function userMaster()
    {
        return $this->hasMany(__CLASS__);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getOfficeListAttribute()
    {
        $OfficeList = [];
        foreach ($this->where('group_num', 1)->select('id', 'name')->get()->toArray() as $value){
            $OfficeList += [$value['id'] => $value['name']];
        }
        return $OfficeList;
    }

}
