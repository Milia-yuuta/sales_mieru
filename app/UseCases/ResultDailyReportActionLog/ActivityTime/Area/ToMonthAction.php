<?php

namespace App\UseCases\ResultDailyReportActionLog\ActivityTime\Area;

use App\Models\ResultDailyReportActionLog;
use App\UseCases\ResultDailyReportActionLog\ActivityTime\PeriodJudgment;

class ToMonthAction extends PeriodJudgment
{
    public function __invoke():array
    {
        $area_a_count = ResultDailyReportActionLog::whereIn('daily_report_id', $this->ToMonth())
            ->where('action_master_id', 24)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();

        $area_b_count = ResultDailyReportActionLog::whereIn('daily_report_id', $this->ToMonth())
            ->where('action_master_id', 25)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();
        $area_c_count = ResultDailyReportActionLog::whereIn('daily_report_id', $this->ToMonth())
            ->where('action_master_id', 26)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();
        $area_d_count = ResultDailyReportActionLog::whereIn('daily_report_id', $this->ToMonth())
            ->where('action_master_id', 27)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();
        $area_e_count = ResultDailyReportActionLog::whereIn('daily_report_id', $this->ToMonth())
            ->where('action_master_id', 28)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();
        $area_f_count = ResultDailyReportActionLog::whereIn('daily_report_id', $this->ToMonth())
            ->where('action_master_id', 29)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();
        $area_g_count = ResultDailyReportActionLog::whereIn('daily_report_id', $this->ToMonth())
            ->where('action_master_id', 30)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();
        $area_h_count = ResultDailyReportActionLog::whereIn('daily_report_id', $this->ToMonth())
            ->where('action_master_id', 31)
            ->selectRaw('sum(start_time) as start_time, sum(end_time) as end_time')
            ->first();

        return [
            'A' => ($area_a_count->end_time - $area_a_count->start_time)/10000,
            'B' => ($area_b_count->end_time - $area_b_count->start_time)/10000,
            'C' => ($area_c_count->end_time - $area_c_count->start_time)/10000,
            'D' => ($area_d_count->end_time - $area_d_count->start_time)/10000,
            'E' => ($area_e_count->end_time - $area_e_count->start_time)/10000,
            'F' => ($area_f_count->end_time - $area_f_count->start_time)/10000,
            'G' => ($area_g_count->end_time - $area_g_count->start_time)/10000,
            'H' => ($area_h_count->end_time - $area_h_count->start_time)/10000,
        ];
    }
}