<?php


namespace App\UseCases\ResultDailyReportActionLog;

use App\Models\ResultDailyReportActionLog;

class ResultUpdate
{
    public function __invoke($request)
    {
        $ResultDailyReportActionLog = ResultDailyReportActionLog::find($request->input('result_daily_report_action_log_id'))->fill($request->all())->save();
        return $ResultDailyReportActionLog;
    }
}
