<?php

namespace App\View\Components\ExcavationBehaviorLog;

use App\Models\ActionMaster;
use Illuminate\View\Component;

class areaSelect extends Component
{
    public $areas;

    public function __construct(ActionMaster $actionMaster)
    {
        $AreaList =  ['' => '---'];
        foreach (ActionMaster::query()->where('group_num', 7)->whereIn('id', \Auth::user()->AllAreaSearch)->select('id','action_name')->get()->toArray() as $value){
            $AreaList += [$value['id'] => $value['action_name']];
        }
        $this->areas = $AreaList;
    }

    public function render()
    {
        return view('components.excavation-behavior-log.area-select');
    }
}
