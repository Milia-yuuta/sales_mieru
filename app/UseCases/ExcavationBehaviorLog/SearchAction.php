<?php


namespace App\UseCases\ExcavationBehaviorLog;
use App\Models\ExcavationBehaviorLog;
use Illuminate\Support\Facades\Auth;

class SearchAction
{
    public function __invoke($request)
    {
        return ExcavationBehaviorLog::where('user_id', Auth::user()->id)->where('area_master_id', $request->area)->where('action_date', $request->date)->first();
    }
}