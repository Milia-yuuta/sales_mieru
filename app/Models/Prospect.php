<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prospect extends Model
{
    use Sortable;
    use softDeletes;

    protected $fillable = [
        'user_id', 'office_master_id','area_master_id','input_person','date', 'latest_date', 'usage_action_master_id', 'generating_medium_master_id', 'source_media_site_master_id', 'remark', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $dates = ['date', 'deleted_at', 'latest_date'];

    public $sortable = ['date'];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function favorites(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProspectFavorite::class);
    }

    public function prospectActionLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProspectActionLog::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function propertyRooms(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PropertyRoom::class);
    }

    public function propertyRoom(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PropertyRoom::class);
    }


    public function nextProspectActionLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(NextProspectActionLog::class);
    }

    public function usage()
    {
        return $this->belongsTo(ActionMaster::class, 'usage_action_master_id');
    }

    /*
    |--------------------------------------------------------------------------
    | delete methods
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
        static::deleting(function($model) {
            foreach ($model->prospectActionLogs()->get() as $child) {
                $child->delete();
            }
            foreach ($model->nextProspectActionLogs()->get() as $child) {
                $child->delete();
            }
            foreach ($model->propertyRooms()->get() as $child) {
                $child->delete();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Custum Methods
    |--------------------------------------------------------------------------
    */
    public function getMediumAttribute()
    {
        return ActionMaster::find($this->generating_medium_master_id)->actionMaster->action_name;
    }

    public function getMedium2Attribute()
    {
        return ActionMaster::find($this->generating_medium_master_id)->action_name;
    }

    public function getMediumSiteAttribute()
    {
        return ActionMaster::find($this->source_media_site_master_id)->action_name;
    }

    public function getCssStageNameAttribute()
    {
        $stage_id = $this->stage_action_master_id;
        switch ($stage_id){
            case 1:
                return "discrimination";
            case 2:
                return "latent";
            case 3:
                return "overt";
            case 4:
                return "mediation";
            case 5:
                return "ExcavationDemotion";
        }
    }

    public function getStatusNameAttribute()
    {
        return ActionMaster::find($this->status_action_master_id)->action_name;
    }

    public function getStageStayDateAttribute()
    {
        $prospectActionLogs = $this->prospectActionLogs->sortByDesc('date')->sortByDesc('created_at');
        $stage_id =  $prospectActionLogs?->first()?->stage_action_master_id;
        $date = 0;

        foreach ($prospectActionLogs as $prospectActionLog){
            if ($stage_id !== $prospectActionLog->stage_action_master_id){
                return  $date;
            }
            $date = Carbon::now()->diffInDays($prospectActionLog->date);
            $stage_id = $prospectActionLog->stage_action_master_id;
        }

        if ($date === 0) {
            $date = Carbon::now()->diffInDays($prospectActionLogs?->last()?->date);
        }

        return $date;
    }

    public function getLatestActionDateAttribute()
    {
        $date = 0;
        foreach ($this->prospectActionLogs->sortByDesc('date') as $prospectActionLog){
            if ($prospectActionLog->TEL_home === 1 ||
                $prospectActionLog->send_letter === 1 ||
                $prospectActionLog->local_letter === 1 ||
                $prospectActionLog->email === 1 ||
                $prospectActionLog->visit === 1 ||
                $prospectActionLog->pursuit_other === 1 ||
                $prospectActionLog->assessment_report_email === 1 ||
                $prospectActionLog->send_assessment_report === 1 ||
                $prospectActionLog->web_negotiation === 1 ||
                $prospectActionLog->assessment_negotiation === 1 ||
                $prospectActionLog['re-negotiation'] === 1 ||
                $prospectActionLog->visit_caretaker === 1 ||
                $prospectActionLog->TEL_caretaker === 1 ||
                $prospectActionLog['on-site_check'] === 1 ||
                $prospectActionLog->re_TEL === 1 ||
                $prospectActionLog->re_email === 1 ||
                $prospectActionLog->re_letter === 1 ||
                $prospectActionLog->re_hp === 1 ||
                $prospectActionLog->re_site === 1 ||
                $prospectActionLog->re_other === 1 ||
                $prospectActionLog->re_hp === 1
            ){
                $date = Carbon::now()->diffInDays($prospectActionLog->date);
                return  $date;
            }
        }
        if ($date === 0){
            $date = '-';
        }
        return $date;
    }


}
