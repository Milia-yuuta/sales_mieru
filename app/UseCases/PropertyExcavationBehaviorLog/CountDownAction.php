<?php


namespace App\UseCases\PropertyExcavationBehaviorLog;

use App\Models\PropertyExcavationBehaviorLog;
use App\Models\ExcavationBehaviorLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CountDownAction
{
    public function __invoke($request)
    {
        $request = $request->merge([
            'action_date' => Carbon::now()->format('Y-m-d'),
            'user_id' => Auth::user()->id,
            $request->action_name => 0,
            'property_id' => $request->property_id,
        ]);

        //顧客毎発掘行動
        $PropertyExcavationBehaviorLog = PropertyExcavationBehaviorLog::query()->whereDate('action_date', Carbon::now()->format('Y-m-d'))->where('user_id', Auth::user()->id)->where('property_id', $request->property_id);
        $PropertyExcavationBehaviorLog->first()->fill($request->all())->save();

        //発掘行動
        $this->ExcavationBehaviorLogStore($request);
    }

    //発掘行動へ保存
    private function ExcavationBehaviorLogStore($request): void
    {
        $ExcavationBehaviorLog = ExcavationBehaviorLog::query()->where('user_id', Auth::user()->id)->where('area_master_id', $request->area_master_id)->whereDate('action_date', Carbon::now()->format('Y-m-d'));
        if ($ExcavationBehaviorLog->get()->isNotEmpty()){
            //Updateの場合
            $this->ExcavationBehaviorLogUpdate($ExcavationBehaviorLog, $request);
        }
    }

    //Updateの場合
    private function ExcavationBehaviorLogUpdate($ExcavationBehaviorLog, $request): void
    {
        if (isset($request->manager_visit_count)){
            $ExcavationBehaviorLog->decrement('manager_visit_count');
        }elseif(isset($request->check_building_count)){
            $ExcavationBehaviorLog->decrement('check_building_count');
        }elseif(isset($request->manager_TEL_count)){
            $ExcavationBehaviorLog->decrement('manager_TEL_count');
        }
    }
}