<?php


namespace App\UseCases\ProspectActionLog;

use App\Models\ProspectActionLog;
use App\Models\Prospect;
use Carbon\Carbon;

class UpdateAction
{
    public function __invoke($request): bool
    {
        $request['stage_stay_date'] = $this->StageStayDateCalc($request);
        $ProspectActionLogInstance = ProspectActionLog::find($request->input('ProspectActionLog_id'));
        $ProspectActionLogInstance = $ProspectActionLogInstance->fill($request->all())->save();
        $prospect = Prospect::find($request->prospect_id);
        $prospect->fill(['latest_date' => $request->input('date')])->save();
        $firstProspect = Prospect::find($request->prospect_id);
        if((int)$request->ProspectActionLog_id === $firstProspect->prospectActionLogs->first()->id){
            $firstProspect->fill(['date' => $request->date])->save();
        }
        return $ProspectActionLogInstance;
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

    private function checkRequest()
    {

    }
}
