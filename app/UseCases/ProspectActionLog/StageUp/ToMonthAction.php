<?php

namespace App\UseCases\ProspectActionLog\StageUp;

use App\Models\Prospect;
use App\Models\ProspectActionLog;
use Carbon\Carbon;

class ToMonthAction
{
    public function __invoke($request): ?array
    {
        if (empty(ProspectActionLog::where('user_id', $request->input('SearchUser')))){
            return NULL;
        }
        $prospects = Prospect::with('prospectActionLogs')
            ->where('user_id', $request->input('SearchUser'))
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date',  Carbon::now()->month)
            ->get();

        return [
            'LatentFromDiscrimination' => $this->StageUpCheck($prospects, 1, 2),
            'OvertFromDiscrimination' => $this->StageUpCheck($prospects, 1, 3),
            'OvertFromLatent' => $this->StageUpCheck($prospects, 2, 3),
        ];
    }

    private function StageUpCheck($prospects, $start_stage_id, $end_stage_id): int
    {
        $count = 0;
        foreach ($prospects as $prospect){
            if ($prospect->prospectActionLogs->first()->stage_action_master_id == $start_stage_id
                && $prospect->prospectActionLogs->last()->stage_action_master_id == $end_stage_id){
                $count ++;
            }
        }
        return $count;
    }
}
