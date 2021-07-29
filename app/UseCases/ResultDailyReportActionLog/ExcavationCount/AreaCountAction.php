<?php


namespace App\UseCases\ResultDailyReportActionLog\ExcavationCount;

use App\UseCases\ResultDailyReportActionLog\ExcavationCount\PeriodJudgment;

class AreaCountAction extends PeriodJudgment
{
    public function __invoke():array
    {
        return[
            '管理人訪問' => [
                'ManagerVisitTodayCount' => $this->ToDay()->sum('manager_visit_count'),
                'ManagerVisitToMonthCount' => $this->ToMonth()->sum('manager_visit_count'),
                'ManagerVisitToPeriodCount' => $this->Period()->sum('manager_visit_count')
            ],

            '個人訪問' => [
                'PersonalVisitTodayCount' => $this->ToDay()->sum('personal_visit_count'),
                'PersonalVisitTodayMonthCount' => $this->ToMonth()->sum('personal_visit_count'),
                'PersonalVisitToPeriodCount' => $this->Period()->sum('personal_visit_count')
            ],

            '一棟C' => [
                'CheckBuildingTodayCount' => $this->ToDay()->sum('check_building_count'),
                'CheckBuildingTodayMonthCount' => $this->ToMonth()->sum('check_building_count'),
                'CheckBuildingToPeriodCount' => $this->Period()->sum('check_building_count'),
            ],

            'DM手まき反響' =>[
                'DMDistributionTodayCount' => $this->ToDay()->sum('DM_distribution_count'),
                'DMDistributionTodayMonthCount' => $this->ToMonth()->sum('DM_distribution_count'),
                'DMDistributionToPeriodCount' => $this->Period()->sum('DM_distribution_count'),
            ],

            'チラシ手まき反響' =>[
                'FlyerDistributionTodayCount' => $this->ToDay()->sum('flyer_distribution_count'),
                'FlyerDistributionTodayMonthCount' => $this->ToMonth()->sum('flyer_distribution_count'),
                'FlyerDistributionToPeriodCount' => $this->Period()->sum('flyer_distribution_count'),
            ],

            '手紙・封書手まき反響' =>[
                'LetterDistributionTodayCount' => $this->ToDay()->sum('letter_distribution_count'),
                'LetterDistributionTodayMonthCount' => $this->ToMonth()->sum('letter_distribution_count'),
                'LetterDistributionToPeriodCount' => $this->Period()->sum('letter_distribution_count'),
            ],

            'ランダム戸別訪問' => [
                'RandomVisitAtHomeTodayCount' => $this->ToDay()->sum('random_visit_at_home_count'),
                'RandomVisitAtHomeTodayMonthCount' => $this->ToMonth()->sum('random_visit_at_home_count'),
                'RandomVisitAtHomeToPeriodCount' => $this->Period()->sum('random_visit_at_home_count'),
            ],
        ];
    }

}