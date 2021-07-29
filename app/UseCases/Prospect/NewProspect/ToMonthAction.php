<?php

namespace App\UseCases\Prospect\NewProspect;

use App\Models\Prospect;
use Carbon\Carbon;

class ToMonthAction
{
    public function __invoke($request): array
    {
        $now = new Carbon();
        $prospects = Prospect::with('prospectActionLogs')
            ->whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->where('user_id', $request->input('SearchUser'))
            ->get();

        return [
            'discrimination' => $this->StageCheck($prospects, 1),
            'latent' => $this->StageCheck($prospects, 2),
            'overt' => $this->StageCheck($prospects, 3)
        ];
    }

    private function StageCheck($prospects, $stage_id): int
    {
        $count = 0;
        foreach ($prospects as $prospect){
           if ($prospect->prospectActionLogs->first()->stage_action_master_id == $stage_id){
               ++$count;
           }
        }
        return $count;
    }
}
