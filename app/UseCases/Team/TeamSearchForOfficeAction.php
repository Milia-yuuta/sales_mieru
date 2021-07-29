<?php


namespace App\UseCases\Team;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class TeamSearchForOfficeAction
{
    public function __invoke($office_master_id)
    {
        $teams = Team::where('office_master_id', $office_master_id)->get();
        $teamArray= [];
        foreach ($teams as $team){
            $hat_name = $team->hat->sei ?? '-';
            $teamArray += [$team->id => "{$team->sale->sei} / {$hat_name}"];
        }
        return $teamArray;
    }
}