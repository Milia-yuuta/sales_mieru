<?php

namespace App\UseCases\ResultDailyReportActionLog\ExcavationCount;

use App\UseCases\ResultDailyReportActionLog\ExcavationCount\PeriodJudgment;

class PreAction extends PeriodJudgment
{
    public function __invoke():array
    {
        return[
            '前取訪問-実施' => [
                'PreVisitTodayCount' => $this->ToDay()->sum('pre_visit_preliminary_count'),
                'PreVisitToMonthCount' => $this->ToMonth()->sum('pre_visit_preliminary_count'),
                'PreVisitToPeriodCount' => $this->Period()->sum('pre_visit_preliminary_count'),
            ],

            '前取訪問-在宅' => [
                'PreHomeTodayCount' => $this->ToDay()->sum('pre_visit_home_count'),
                'PreHomeTodayMonthCount' => $this->ToMonth()->sum('pre_visit_home_count'),
                'PreHomeToPeriodCount' => $this->Period()->sum('pre_visit_home_count'),
            ],

            '前取TEL-在宅' => [
                'PreTELTodayCount' => $this->ToDay()->sum('pre_TEL_home_count'),
                'PreTELTodayMonthCount' => $this->ToMonth()->sum('pre_TEL_home_count'),
                'PreTELToPeriodCount' => $this->Period()->sum('pre_TEL_home_count'),
            ],
        ];
    }

}