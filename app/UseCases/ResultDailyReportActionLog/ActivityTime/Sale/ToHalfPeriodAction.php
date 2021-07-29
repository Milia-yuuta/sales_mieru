<?php


namespace App\UseCases\ResultDailyReportActionLog\ActivityTime\Sale;

use App\Models\ResultDailyReportActionLog;
use App\UseCases\ResultDailyReportActionLog\ActivityTime\PeriodJudgment;

class ToHalfPeriodAction extends PeriodJudgment
{
    public function __invoke():array
    {
        $SaleAction = ResultDailyReportActionLog::whereIn('daily_report_id', $this->Period())
            ->where('action_master_id', 39)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();

        $AgreementAction = ResultDailyReportActionLog::whereIn('daily_report_id', $this->Period())
            ->where('action_master_id', 40)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();

        $SettlementAction = ResultDailyReportActionLog::whereIn('daily_report_id', $this->Period())
            ->where('action_master_id', 41)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();

        return [
            'SaleAction' => ($SaleAction->end_time - $SaleAction->start_time)/10000,
            'AgreementAction' => ($AgreementAction->end_time - $AgreementAction->start_time)/10000,
            'SettlementAction' => ($SettlementAction->end_time - $SettlementAction->start_time)/10000,
        ];
    }
}