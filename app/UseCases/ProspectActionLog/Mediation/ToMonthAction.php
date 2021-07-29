<?php

namespace App\UseCases\ProspectActionLog\Mediation;

use App\Models\Prospect;
use App\Models\ProspectActionLog;
use Carbon\Carbon;

class ToMonthAction
{
    //当月の媒介数
    public function __invoke($request): ?array
    {
        if (ProspectActionLog::where('user_id', $request->input('SearchUser')) === null){
            return NULL;
        }

        $prospects = Prospect::with('prospectActionLogs')
            ->where('user_id', $request->input('SearchUser'))
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->get();

        return [
            'DedicatedIntermediaryCount' => $this->StatusCheck($prospects, 15),
            'SellerCount' => $this->StatusCheck($prospects, 14),
            'PanpyCount' => $this->StatusCheck($prospects, 16),
            'ExclusiveCount' => $this->StatusCheck($prospects, 17),
        ];
    }

    private function StatusCheck($prospects, $status_id): int
    {
        $count = 0;
        foreach ($prospects as $prospect) {
            $count += $prospect
                ->prospectActionLogs
                ->where('stage_action_master_id', 4)
                ->where('status_action_master_id', $status_id)
                ->count();
        }
        return $count;
    }
}
