<?php


namespace App\UseCases\ResultDailyReportActionLog\ActivityTime\InCompany;

use App\Models\ResultDailyReportActionLog;
use App\UseCases\ResultDailyReportActionLog\ActivityTime\PeriodJudgment;

class ToHalfPeriodAction extends PeriodJudgment
{
    public function __invoke():array
    {
        $PurchasingActivities = ResultDailyReportActionLog::whereIn('daily_report_id', $this->Period())
            ->where('action_master_id', 32)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();

        $OfficeWork = ResultDailyReportActionLog::whereIn('daily_report_id', $this->Period())
            ->where('action_master_id', 33)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();

        return [
            'PurchasingActivities' => ($PurchasingActivities->end_time - $PurchasingActivities->start_time)/10000,
            'OfficeWork' => ($OfficeWork->end_time - $OfficeWork->start_time)/10000,
        ];
    }
}