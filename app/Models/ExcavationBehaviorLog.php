<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExcavationBehaviorLog extends Model
{
    protected $fillable = [
        'user_id', 'action_date',
        'manager_visit_count', 'personal_visit_count','DM_distribution_count', 'flyer_distribution_count', 'letter_distribution_count', 'random_visit_implementation_count',
        'random_visit_at_home_count', 'manager_TEL_count', 'personal_TEL_count', 'random_TEL_implementation_count', 'random_TEL_at_home_count', 'flyer_delivery_count', 'DM_mail_count',
        'pre_visit_preliminary_count', 'pre_visit_home_count', 'pre_TEL_home_count', 'check_building_count', 'mail_letter_count',
        'office_master_id', 'area_master_id', 'status_id',
        'check_post_count', 'patrol_local_information', 'return_to_mail', 'rental_information', 'registration_information', 'building_confirmation_information', 'created_at', 'updated_at'
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

}
