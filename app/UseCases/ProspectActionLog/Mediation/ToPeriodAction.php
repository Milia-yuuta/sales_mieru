<?php

namespace App\UseCases\ProspectActionLog\Mediation;

use App\Models\Prospect;
use App\Models\ProspectActionLog;
use Carbon\Carbon;

class ToPeriodAction
{
    //半期の媒介数
    public function __invoke($request): ?array
    {
        if (ProspectActionLog::where('user_id', $request->input('SearchUser')) === null){
            return NULL;
        }

        switch (Carbon::now()->quarter){
            case 1 && 2:
                $start_period = Carbon::now()->startOfMonth()->month(1);
                $end_period =  Carbon::now()->endOfMonth()->month(6);
                break;
            case 3 && 4:
                $start_period = Carbon::now()->startOfMonth()->month(7);
                $end_period =  Carbon::now()->endOfMonth()->month(12);
                break;
        }

        $prospects = Prospect::with('prospectActionLogs')
            ->where('user_id', $request->input('SearchUser'))
            ->whereBetween('date', [$start_period, $end_period])
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
