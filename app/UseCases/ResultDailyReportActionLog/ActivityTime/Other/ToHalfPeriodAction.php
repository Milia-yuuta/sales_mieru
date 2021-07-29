<?php


namespace App\UseCases\ResultDailyReportActionLog\ActivityTime\Other;

use App\Models\ResultDailyReportActionLog;
use App\UseCases\ResultDailyReportActionLog\ActivityTime\PeriodJudgment;

class ToHalfPeriodAction extends PeriodJudgment
{
    public function __invoke():array
    {
        $other = ResultDailyReportActionLog::whereIn('daily_report_id', $this->Period())
            ->where('action_master_id', 42)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();

        return [
            'other' => ($other->end_time - $other->start_time)/10000
        ];
    }
}