<?php


namespace App\UseCases\ResultDailyReportActionLog;

use App\Models\ResultDailyReportActionLog;

class DeleteAction
{
    public function __invoke($request)
    {
        ResultDailyReportActionLog::find($request->result_daily_report_action_log_id)->delete();
    }
}