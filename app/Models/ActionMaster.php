<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionMaster extends Model
{
    protected $fillable = [
        'action_master_id', 'name', 'val', 'group_num', 'seq','created_at', 'updated_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function actionMaster()
    {
        return $this->hasOne(ActionMaster::class, 'id', 'action_master_id');
    }

    public function dailyReportActionLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DailyReportActionLog::class);
    }

    public function excavationBehaviorLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ExcavationBehaviorLog::class);
    }

    public function prospectActionLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProspectActionLog::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Custum Methods
    |--------------------------------------------------------------------------
    */

    public function getStageListAttribute(): array
    {
        $StageList =  [];
        foreach ($this->where('id','<', 4)->select('id','action_name')->get()->toArray() as $value){
            $StageList += [$value['id'] => $value['action_name']];
        }
        return $StageList;
    }

    public function getSearchStageListAttribute(): array
    {
        $StageList =  [0 => 'ALL'];
        foreach ($this->where('id','<', 4)->select('id','action_name')->get()->toArray() as $value){
            $StageList += [$value['id'] => $value['action_name']];
        }
        return $StageList;
    }

    public function getAreaListAttribute()
    {
        $AreaList =  [0 => 'ALL'];
        foreach ($this->where('group_num', 7)->select('id','action_name')->get()->toArray() as $value){
            $AreaList += [$value['id'] => $value['action_name']];
        }
        return $AreaList;
    }

    public function getAreaSetListAttribute()
    {
        $AreaList =  [];
        foreach ($this->where('group_num', 7)->select('id','action_name')->get()->toArray() as $value){
            $AreaList += [$value['id'] => $value['action_name']];
        }
        return $AreaList;
    }

    public function getModalStageListAttribute(): array
    {
        $StageList = [];
        foreach ($this->where('group_num',1 )->select('id','action_name')->get()->toArray() as $value){
            $StageList += [$value['id'] => $value['action_name']];
        }
        return $StageList;
    }

    public function getStatusListAttribute(): array
    {
        $StatusList = [0 => '---'];
        foreach ($this->where('group_num', 2 )->select('id','action_name')->get()->toArray() as $value){
            $StatusList += [$value['id'] => $value['action_name']];
        }
        return $StatusList;
    }

    public function getModelStatusListAttribute(): array
    {
        $StatusList = [];
        foreach ($this->where('group_num', 2 )->select('id','action_name')->get()->toArray() as $value){
            $StatusList += [$value['id'] => $value['action_name']];
        }
        return $StatusList;
    }

    public function getAllStatusListAttribute():array
    {
        $StatusList = [];
        foreach ($this->whereIn('group_num', [2,3,4,5] )->select('id','action_name')->get()->toArray() as $value){
            $StatusList += [$value['id'] => $value['action_name']];
        }
        return $StatusList;
    }

    public function StatuselongingStage($id)
    {
        $StatusList = [0 => 'ALL'];
        switch ($id){
            case 1:
                foreach ($this->where('group_num', 2)->select('id','action_name')->get()->toArray() as $value){
                    $StatusList += [$value['id'] => $value['action_name']];
                }
                return $StatusList;
            case 2:
                foreach ($this->where('group_num', 3)->select('id','action_name')->get()->toArray() as $value){
                    $StatusList += [$value['id'] => $value['action_name']];
                }
                return $StatusList;
            case 3:
                foreach ($this->where('group_num', 4)->select('id','action_name')->get()->toArray() as $value){
                    $StatusList += [$value['id'] => $value['action_name']];
                }
                return $StatusList;

        }

    }

    public function getTopGeneratingMediumAttribute(): array
    {
        $GeneratingMediumList = [];
        foreach ($this->where('group_num', 8 )->select('id','action_name')->get()->toArray() as $value){
            $GeneratingMediumList += [$value['id'] => $value['action_name']];
        }
        return $GeneratingMediumList;
    }

    //発生媒体2
    public function getGeneratingMediumAttribute($request): array
    {
        $GeneratingMediumList = [];
        $area = [];
        $company = [];
        $response = [];
        $Re = [];
        $other = [];
        //エリア発掘が親の媒体
        foreach ($this->where('group_num', 9)->select('id','action_name')->get()->toArray() as $value){
            $area += [$value['id'] => $value['action_name']];
        }
        //社内発掘が親の媒体
        foreach ($this->where('group_num', 10)->select('id','action_name')->get()->toArray() as $value){
            $company += [$value['id'] => $value['action_name']];
        }
        //反響が親の媒体
        foreach ($this->where('group_num', 11)->select('id','action_name')->get()->toArray() as $value){
            $response += [$value['id'] => $value['action_name']];
        }
        //前取りが親の媒体
        foreach ($this->where('group_num', 11)->select('id','action_name')->get()->toArray() as $value){
            $Re += [$value['id'] => $value['action_name']];
        }
        //その他が親の媒体
        foreach ($this->where('group_num', 11)->select('id','action_name')->get()->toArray() as $value){
            $other += [$value['id'] => $value['action_name']];
        }
        $GeneratingMediumList = array_merge(['area' => $area], ['company' => $company], ['response' => $response], ['Re' => $Re],['other' => $other]);
        return $GeneratingMediumList;
    }

    public function getSiteListAttribute()
    {
        $SiteList = [];
        foreach ($this->where('group_num', 23)->select('id','action_name')->get()->toArray() as $value){
            $SiteList += [$value['id'] => $value['action_name']];
        }
        return $SiteList;
    }

    public function getUsagePatternAttribute()
    {
        $UsagePatternList = [];
        foreach ($this->where('group_num', 16)->select('id','action_name')->get()->toArray() as $value){
            $UsagePatternList += [$value['id'] => $value['action_name']];
        }
        return $UsagePatternList;
    }

    public function ThisAction($request)
    {
        return $this->find($request);
    }

    //日報大項目取得
    public function getDailyReportPrimaryItemAttribute(): array
    {
        $DailyReportPrimaryItem = ['---'];
        foreach($this->where('group_num', 6)->get()->toArray() as $value){
            $DailyReportPrimaryItem += [$value['id'] => $value['action_name']];
        }
        return $DailyReportPrimaryItem;
    }

    //日報小項目取得
    public function getDailyReportTertiaryItemAttribute(): array
    {
        $DailyReportTertiaryItem = [];
        foreach($this->whereIN('group_num', [7,17,18,19,20,21])->get()->toArray() as $value){
            $DailyReportTertiaryItem += [$value['id'] => $value['action_name']];
        }
        return $DailyReportTertiaryItem;
    }

}
