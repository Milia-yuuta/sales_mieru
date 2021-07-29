<?php


namespace App\UseCases\DailyReport;

use App\Models\DailyReport;

class StoreAction
{
    public function __construct()
    {

    }

    public function __invoke($request)
    {
        $dailyReportInstance = new DailyReport;
        $request->merge([
            'date' => str_replace('.', '-', $request->input('date')),
            'plan_check' => 0,
            'result_check' => 0,
        ]);
        $dailyReportInstance->fill($request->all())->save();
        return $dailyReportInstance;
    }

}