<?php


namespace App\UseCases\ResultDailyReportActionLog\ActivityTime;

use Carbon\Carbon;
use App\Models\DailyReport;
use Illuminate\Support\Facades\Auth;

class PeriodJudgment
{
    protected function Period(): \Illuminate\Support\Collection
    {
        $now = new Carbon();
        if (3 > $now->month && $now->month > 10){
            $DailyReportInstance = DailyReport::query()
                ->where('user_id', Auth::user()->id)
                ->whereYear('created_at', $now->year)
                ->whereMonth('created_at', 4)
                ->orWhereMonth('created_at', 5)
                ->orWhereMonth('created_at', 6)
                ->orWhereMonth('created_at', 7)
                ->orWhereMonth('created_at', 8)
                ->orWhereMonth('created_at', 9)
                ->pluck('id');
            return $DailyReportInstance;
        }else{
            $DailyReportInstance = DailyReport::query()
                ->where('user_id', Auth::user()->id)
                ->whereYear('created_at', $now->year)
                ->whereMonth('created_at', 1)
                ->orWhereMonth('created_at', 2)
                ->orWhereMonth('created_at', 3)
                ->orWhereMonth('created_at', 10)
                ->orWhereMonth('created_at', 11)
                ->orWhereMonth('created_at', 12)
                ->pluck('id');
            return $DailyReportInstance;
        }
    }

    protected function ToMonth(): \Illuminate\Support\Collection
    {
        $now = new Carbon();
        $DailyReportInstance = DailyReport::query()
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->where('user_id', Auth::user()->id)
            ->pluck('id');
        return $DailyReportInstance;
    }
}