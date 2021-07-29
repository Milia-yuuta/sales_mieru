<?php

namespace App\UseCases\ResultDailyReportActionLog\AssessmentVisitCount;

use Carbon\Carbon;
use App\Models\Prospect;

class TodayAction
{
    public function __invoke($request): ?array
    {
        if (empty(Prospect::where('user_id', $request->input('SearchUser')))){
            return NULL;
        }

        $prospects = Prospect::with('prospectActionLogs')
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->where('user_id', $request->input('SearchUser'))
            ->get();

        return  [
            'DiscriminationCount' => $this->AssessmentVisitCheck($prospects, 1),
            'LatentCount' => $this->AssessmentVisitCheck($prospects, 2),
            'OvertCount' => $this->AssessmentVisitCheck($prospects, 3)
        ];
    }

    private function AssessmentVisitCheck($prospects, $stage_id):int
    {
        $count = 0;
        foreach ($prospects as $prospet){
            $count += $prospet
                ->prospectActionLogs
                ->where('stage_action_master_id', $stage_id)
                ->where('assessment_negotiation', 1)
                ->count();
        }
        return $count;
    }

}
