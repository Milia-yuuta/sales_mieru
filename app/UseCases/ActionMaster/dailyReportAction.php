<?php


namespace App\UseCases\ActionMaster;
use App\Models\ActionMaster;

class dailyReportAction
{
    public function __invoke(): array
    {
        $actionMasters = ActionMaster::query()->whereIn('action_master_id', [18, 19, 20, 21, 22, 23])->get();
        $areaList = ['---'];
        $officeList = ['---'];
        $visitList = ['---'];
        $meetingList = ['---'];
        $agreementList = ['---'];
        $otherList = ['---'];


        foreach ($actionMasters->where('group_num', 7) as $value){
            $areaList += [$value['id'] => $value['action_name']];
        }
        foreach ($actionMasters->where('group_num', 17) as $value){
            $officeList += [$value['id'] => $value['action_name']];
        }
        foreach ($actionMasters->where('group_num', 18) as $value){
            $visitList += [$value['id'] => $value['action_name']];
        }
        foreach ($actionMasters->where('group_num', 19) as $value){
            $meetingList += [$value['id'] => $value['action_name']];
        }

        foreach ($actionMasters->where('group_num', 20) as $value){
            $agreementList += [$value['id'] => $value['action_name']];
        }

        foreach ($actionMasters->where('group_num', 21) as $value){
            $otherList += [$value['id'] => $value['action_name']];
        }

        return array_merge(['area' => $areaList], ['office' => $officeList], ['visit' => $visitList], ['meeting' => $meetingList], ['agreement' => $agreementList], ['other' => $otherList]);
    }
}