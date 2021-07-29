<?php


namespace App\UseCases\ResultDailyReportActionLog\ActivityTime\Meeting;

use App\Models\ResultDailyReportActionLog;
use App\UseCases\ResultDailyReportActionLog\ActivityTime\PeriodJudgment;

class ToHalfPeriodAction extends PeriodJudgment
{
    public function __invoke():array
    {
        $InCompanyMeeting = ResultDailyReportActionLog::whereIn('daily_report_id', $this->Period())
            ->where('action_master_id', 37)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();

        $Training = ResultDailyReportActionLog::whereIn('daily_report_id', $this->Period())
            ->where('action_master_id', 38)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();

        return [
            'InCompanyMeeting' => ($InCompanyMeeting->end_time - $InCompanyMeeting->start_time)/10000,
            'Training' => ($Training->end_time - $Training->start_time)/10000,
        ];
    }
}