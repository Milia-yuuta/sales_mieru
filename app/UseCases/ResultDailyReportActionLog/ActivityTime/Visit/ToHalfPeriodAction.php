<?php


namespace App\UseCases\ResultDailyReportActionLog\ActivityTime\Visit;

use App\Models\ResultDailyReportActionLog;
use App\UseCases\ResultDailyReportActionLog\ActivityTime\PeriodJudgment;

class ToHalfPeriodAction extends PeriodJudgment
{
    public function __invoke():array
    {
        $WebNegotiations = ResultDailyReportActionLog::whereIn('daily_report_id', $this->Period())
            ->where('action_master_id', 34)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();

        $Negotiations = ResultDailyReportActionLog::whereIn('daily_report_id', $this->Period())
            ->where('action_master_id', 35)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();

        $ReNegotiations = ResultDailyReportActionLog::whereIn('daily_report_id', $this->Period())
            ->where('action_master_id', 36)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();

        return [
            'WebNegotiations' => ($WebNegotiations->end_time - $WebNegotiations->start_time)/10000,
            'Negotiations' => ($Negotiations->end_time - $Negotiations->start_time)/10000,
            'ReNegotiations' => ($ReNegotiations->end_time - $ReNegotiations->start_time)/10000,
        ];
    }
}