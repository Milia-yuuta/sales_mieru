<?php

namespace App\UseCases\ExcavationBehaviorLog;

use App\Models\ExcavationBehaviorLog;
use Illuminate\Support\Facades\Auth;

class StoreAction
{
    public function __invoke($request)
    {
        $request->merge([
            'office_master_id' => Auth::user()->office_master_id,
            'status_id' => Auth::user()->status_id,
        ]);
        $excavation_instance = ExcavationBehaviorLog::where('user_id', $request->user_id)->where('area_master_id', $request->input('area_master_id'))->where('action_date', $request->input('action_date'));
        if ($excavation_instance->get()->isNotEmpty()){
            $excavation_instance->first()->fill($request->all())->save();
        }else{
            $excavation_instance = new ExcavationBehaviorLog;
            $excavation_instance->fill($request->all())->save();
        }
    }
}