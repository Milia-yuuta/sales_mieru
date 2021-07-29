<?php


namespace App\UseCases\ResultDailyReportActionLog;

use App\Models\ResultDailyReportActionLog;

class ResultStoreAction
{
    public function __invoke($request)
    {
        $DailyReportActionLogInstance = new ResultDailyReportActionLog;
        $request->merge(['start_time' => date('H:i' ,strtotime($request->start_time))]);
        $request->merge(['end_time' => date('H:i' ,strtotime($request->end_time))]);
        $DailyReportActionLogInstance->fill($request->all())->save();
        return $DailyReportActionLogInstance;
    }
}