<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PrefectureMaster extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }


    public function getPrefectureNameAttribute()
    {
        $prefectureList = [];
        foreach ($this->query()->get()->toArray() as $prefecture){
            $prefectureList += [$prefecture['id'] => $prefecture['name']];
        }
        return $prefectureList;
    }
}
