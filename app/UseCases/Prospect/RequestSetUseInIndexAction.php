<?php


namespace App\UseCases\Prospect;


use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class RequestSetUseInIndexAction
{
    public function __invoke($request)
    {
        if (empty($request->all())){
            return
                $request->merge([
                    'display_stage' => 'on',
                    'display_status' => 'on',
                    'display_mansion' => 'on',
                    'display_room' => 'on',
                    'display_elapsed' => 'on',
                    'display_stay' => 'on',
                    'display_next_action_date'=> 'on',
                    'display_memo' => 'on',
                    'office' => Auth::user()->office_master_id,
                    'user_area' => $this->areaSearch(),
                    'area' =>$this->areaSearch()->first(),
                ]);
        }
        if ($request->input('area') == 0) {
            $request->merge(['display_person' => 'on']);
        }
        return $request;
    }

    protected function areaSearch()
    {
        if (Auth::user()->sales->isNotEmpty()){
            return Auth::user()->sales->pluck('area_master_id');
        }elseif(Auth::user()->hats->isNotEmpty()){
            return Auth::user()->hats->pluck('area_master_id');
        }else{
            return Team::query()->where('office_master_id', Auth::user()->office_master_id)->pluck('area_master_id');
        }
    }

}