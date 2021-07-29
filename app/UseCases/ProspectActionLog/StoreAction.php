<?php

namespace App\UseCases\ProspectActionLog;

use App\Models\Prospect;
use App\Models\ProspectActionLog;
use App\models\NextProspectActionLog;
use Carbon\Carbon;
use lluminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class StoreAction
{
    //引数はArray
    public function __invoke($request): ProspectActionLog
    {
        if (empty($request['date'])) $request['date'] = Carbon::now()->format('Y-m-d') ;
        $request['stage_stay_date'] = $this->StageStayDateCalc($request);
        $prospect_action_log_instance = new ProspectActionLog;
        $prospect_action_log_instance->fill($request)->save();
        $prospect_action_log_instance->prospect->fill(['latest_date' => $request['date']])->save();
        return $prospect_action_log_instance;
    }

    private function StageStayDateCalc($request): int
    {
        $ProspectActionLog = ProspectActionLog::where('prospect_id', $request['prospect_id'])->orderByDesc('date')->first();
        if (empty($ProspectActionLog)) return 0 ;
        if ($request['stage_action_master_id'] == $ProspectActionLog->stage_action_master_id){
            return Carbon::createMidnightDate($request['date'])->diffInDays($ProspectActionLog->date);
        }
        return 0;
    }
}
