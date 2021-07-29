<?php


namespace App\UseCases\DailyReportActionLog;

use App\Models\DailyReportActionLog;

class PlanStoreAction
{

    public function __invoke($request)
    {
        $DailyReportActionLogInstance = new DailyReportActionLog;
        $request->merge(['start_time' => date('H:i' ,strtotime($request->start_time))]);
        $request->merge(['end_time' => date('H:i' ,strtotime($request->end_time))]);
        $DailyReportActionLogInstance->fill($request->all())->save();
        return $DailyReportActionLogInstance;
    }
}