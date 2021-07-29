<?php


namespace App\UseCases\ProspectActionLog;


use App\Models\ProspectActionLog;

class DateChangeAction
{
    public function __invoke($request): bool
    {
        return ProspectActionLog::where('prospect_id', $request->input('prospect_id'))->first()->fill(['date' => $request->input('date')])->save();
    }
}