<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    protected $fillable = [
        'name',
        'tel',
        'mobile',
        'fax',
        'email',
        's_mobile_email',
        'mobile_email',
        'zip_code',
        'address1',
        'address2',
        'address3',
        'address4',
        'address_check',
        'tel_check',
        'mobile_check',
        'email_check',
        's_mobile_email_check',
        'mobile_email_check',
        'created_at',
        'updated_at',
    ];

    public const TYPE = [
        'INDIVIDUAL'  => 1,
        'CORPORATION' => 2,
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function propertyRooms()
    {
        return $this->hasMany(PropertyRoom::class);
    }

}
