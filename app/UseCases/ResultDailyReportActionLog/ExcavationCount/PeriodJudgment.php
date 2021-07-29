<?php


namespace App\UseCases\ResultDailyReportActionLog\ExcavationCount;

use Carbon\Carbon;
use App\Models\ExcavationBehaviorLog;
use Illuminate\Support\Facades\Auth;

class PeriodJudgment
{
    protected function Period()
    {
        $now = new Carbon();
        if (3 > $now->month && $now->month > 10){
            $ExcavationBehaviorLogInstance = ExcavationBehaviorLog::query()
                ->where('user_id', Auth::user()->id)
                ->whereYear('action_date', $now->year)
                ->whereMonth('action_date', 4)
                ->orWhereMonth('action_date', 5)
                ->orWhereMonth('action_date', 6)
                ->orWhereMonth('action_date', 7)
                ->orWhereMonth('action_date', 8)
                ->orWhereMonth('action_date', 9);

            return $ExcavationBehaviorLogInstance;
        }else{
            $ExcavationBehaviorLogInstance = ExcavationBehaviorLog::query()
                ->where('user_id', Auth::user()->id)
                ->whereYear('action_date', $now->year)
                ->whereMonth('action_date', 1)
                ->orWhereMonth('action_date', 2)
                ->orWhereMonth('action_date', 3)
                ->orWhereMonth('action_date', 10)
                ->orWhereMonth('action_date', 11)
                ->orWhereMonth('action_date', 12);

            return $ExcavationBehaviorLogInstance;
        }
    }

    protected function ToMonth()
    {
        $now = new Carbon();
        $ExcavationBehaviorLogInstance = ExcavationBehaviorLog::query()
            ->whereYear('action_date', $now->year)
            ->whereMonth('action_date', $now->month)
            ->where('user_id', Auth::user()->id);
        return $ExcavationBehaviorLogInstance;
    }

    protected function ToDay()
    {
        $now = new Carbon();
        $ExcavationBehaviorLogInstance = ExcavationBehaviorLog::query()
            ->whereDate('action_date', $now->format('Y-m-d'))
            ->where('user_id', Auth::user()->id);
        return $ExcavationBehaviorLogInstance;
    }
}