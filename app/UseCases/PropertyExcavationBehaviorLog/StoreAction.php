<?php


namespace App\UseCases\PropertyExcavationBehaviorLog;
use App\Models\ExcavationBehaviorLog;
use App\Models\PropertyExcavationBehaviorLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StoreAction
{
    public function __invoke($request)
    {
        $request = $request->merge([
            'action_date' => Carbon::now()->format('Y-m-d'),
            'user_id' => Auth::user()->id,
            $request->action_name => 1,
            'property_id' => $request->property_id,
        ]);
        $this->PropertyExcavationBehaviorLogStore($request);
        $this->ExcavationBehaviorLogStore($request);
    }

    //顧客毎発掘行動保存
    private function PropertyExcavationBehaviorLogStore($request): void
    {
        $PropertyExcavationBehaviorLog = PropertyExcavationBehaviorLog::query()->whereDate('action_date', Carbon::now()->format('Y-m-d'))->where('user_id', Auth::user()->id)->where('property_id', $request->property_id);
        if ($PropertyExcavationBehaviorLog->get()->isNotEmpty()){
            $PropertyExcavationBehaviorLog->first()
                ->fill($request->all())->save();
        }else{
            $PropertyExcavationBehaviorLog = new PropertyExcavationBehaviorLog;
            $PropertyExcavationBehaviorLog->fill($request->all())->save();
        }
    }

    //発掘行動へ保存
    private function ExcavationBehaviorLogStore($request): void
    {
        $ExcavationBehaviorLog = ExcavationBehaviorLog::query()->where('user_id', Auth::user()->id)->where('area_master_id', $request->area_master_id)->whereDate('action_date', Carbon::now()->format('Y-m-d'));
        if ($ExcavationBehaviorLog->get()->isNotEmpty()){
            //Updateの場合
            $this->ExcavationBehaviorLogUpdate($ExcavationBehaviorLog, $request);
        }else{
            //Newの場合
            $this->ExcavationBehaviorLogNewStore($request);
        }
    }

    //Updateの場合
    private function ExcavationBehaviorLogUpdate($ExcavationBehaviorLog, $request): void
    {
        if (isset($request->manager_visit_count)){
            $ExcavationBehaviorLog->increment('manager_visit_count');
        }elseif(isset($request->check_building_count)){
            $ExcavationBehaviorLog->increment('check_building_count');
        }elseif(isset($request->manager_TEL_count)){
            $ExcavationBehaviorLog->increment('manager_TEL_count');
        }
    }

    //Newの場合
    private function ExcavationBehaviorLogNewStore($request): void
    {
        $NewExcavationBehaviorLog = new ExcavationBehaviorLog;

        if (isset($request->manager_visit_count)){
            $NewExcavationBehaviorLog->fill(['manager_visit_count' => 1, 'user_id' => Auth::user()->id, 'office_master_id' => Auth::user()->office_master_id, 'status_id' => Auth::user()->status_id, 'action_date' => now()->format('Y-m-d'), 'area_master_id' => $request->area_master_id])->save();
        }elseif(isset($request->check_building_count)){
            $NewExcavationBehaviorLog->fill(['manager_TEL_count' => 1, 'user_id' => Auth::user()->id, 'office_master_id' => Auth::user()->office_master_id, 'status_id' => Auth::user()->status_id, 'action_date' => now()->format('Y-m-d'), 'area_master_id' => $request->area_master_id])->save();
        }elseif(isset($request->manager_TEL_count)){
            $NewExcavationBehaviorLog->fill(['check_building_count' => 1, 'user_id' => Auth::user()->id, 'office_master_id' => Auth::user()->office_master_id, 'status_id' => Auth::user()->status_id, 'action_date' => now()->format('Y-m-d'), 'area_master_id' => $request->area_master_id])->save();
        }
    }
}