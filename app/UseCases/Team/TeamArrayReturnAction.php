<?php


namespace App\UseCases\Team;
use App\Models\Team;

class TeamArrayReturnAction
{
    public function __invoke(): array
    {
        $teamInstance = Team::with('sale', 'hat')->get();
        $teamArray = [];
        foreach ($teamInstance as $team){
            $hat_name = $team->hat->sei ?? '-';
            $teamArray += [$team->id => "{$team->sale->sei} / {$hat_name}"];
        }
        return $teamArray;
    }

}