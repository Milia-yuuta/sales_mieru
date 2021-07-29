<?php


namespace App\UseCases\DailyReportActionLog;

use App\Models\DailyReportActionLog;

class PlanUpdate
{
    public function __invoke($request): bool
    {
        $DailyReportActionLogInstance = DailyReportActionLog::find($request->input('daily_report_action_log_id'))->fill($request->all())->save();
        return $DailyReportActionLogInstance;
    }
}
