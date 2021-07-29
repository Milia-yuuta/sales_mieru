<?php


namespace App\UseCases\DailyReportActionLog;
use App\Models\DailyReportActionLog;

class DeleteAction
{
    public function __invoke($request)
    {
        return DailyReportActionLog::find($request->daily_report_action_log_id)->delete();
    }

}