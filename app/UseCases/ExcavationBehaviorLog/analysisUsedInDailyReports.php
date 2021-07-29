<?php


namespace App\UseCases\ExcavationBehaviorLog;


use Carbon\Carbon;
use App\Models\ExcavationBehaviorLog;

class analysisUsedInDailyReports
{
    public function __invoke($request, $date): array
    {
        $TodayExcavationBehaviorLog = $this->Today($request, $date);
        $CheckCountExcavationBehaviorLog = $this->ToMonth($request, $date);
        $HalfCheckCountExcavationBehaviorLog = $this->HalfPeriod($request, $date);
        return array_merge(
            ['area' => $this->area($TodayExcavationBehaviorLog, $CheckCountExcavationBehaviorLog, $HalfCheckCountExcavationBehaviorLog)],
            ['office' => $this->office($TodayExcavationBehaviorLog, $CheckCountExcavationBehaviorLog, $HalfCheckCountExcavationBehaviorLog)],
            ['pre' => $this->pre($TodayExcavationBehaviorLog, $CheckCountExcavationBehaviorLog, $HalfCheckCountExcavationBehaviorLog)]
        );
    }

    //エリア発掘を期間別に算出して配列に
    private function area($TodayExcavationBehaviorLog, $CheckCountExcavationBehaviorLog, $HalfCheckCountExcavationBehaviorLog): array
    {

        return[
            '管理人訪問' => [
                'ManagerVisitTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog, 'manager_visit_count'),
                'ManagerVisitToMonth' => $this->CheckCount($CheckCountExcavationBehaviorLog,'manager_visit_count'),
                'ManagerVisitHalfPeriod' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'manager_visit_count')
            ],

            '個人訪問' => [
                'PersonalVisitTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'personal_visit_count'),
                'PersonalVisitToMonth' => $this->CheckCount($CheckCountExcavationBehaviorLog,'personal_visit_count'),
                'PersonalVisitHalfPeriod' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'personal_visit_count')
            ],

            '一棟C' => [
                'CheckBuildingTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'check_building_count'),
                'CheckBuildingToMonth' => $this->CheckCount($CheckCountExcavationBehaviorLog,'check_building_count'),
                'CheckBuildingHalfPeriod' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'check_building_count'),
            ],

            'DM手まき反響' =>[
                'DMDistributionTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'DM_distribution_count'),
                'DMDistributionToMonth' => $this->CheckCount($CheckCountExcavationBehaviorLog,'DM_distribution_count'),
                'DMDistributionHalfPeriod' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'DM_distribution_count'),
            ],

            'チラシ手まき反響' =>[
                'FlyerDistributionTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'flyer_distribution_count'),
                'FlyerDistributionToMonth' => $this->CheckCount($CheckCountExcavationBehaviorLog,'flyer_distribution_count'),
                'FlyerDistributionHalfPeriod' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'flyer_distribution_count'),
            ],

            '手紙・封書手まき反響' =>[
                'LetterDistributionTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'letter_distribution_count'),
                'LetterDistributionTToMonth' => $this->CheckCount($CheckCountExcavationBehaviorLog,'letter_distribution_count'),
                'LetterDistributionHalfPeriod' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'letter_distribution_count'),
            ],

            'ランダム戸別訪問/実施数' => [
                'RandomVisitAtHomeTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'random_visit_implementation_count'),
                'RandomVisitAtHomeToMonth' => $this->CheckCount($CheckCountExcavationBehaviorLog,'random_visit_implementation_count'),
                'RandomVisitAtHomeHalfPeriod' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'random_visit_implementation_count'),
            ],

            'ランダム戸別訪問/在宅数' => [
                'RandomVisitAtHomeTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'random_visit_at_home_count'),
                'RandomVisitAtHomeToMonth' => $this->CheckCount($CheckCountExcavationBehaviorLog,'random_visit_at_home_count'),
                'RandomVisitAtHomeHalfPeriod' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'random_visit_at_home_count'),
            ],
        ];
    }
    
    //社内発掘を期間別に配列にして算出
    private function office($TodayExcavationBehaviorLog, $CheckCountExcavationBehaviorLog, $HalfCheckCountExcavationBehaviorLog): array
    {
        return[
            '管理人TEL' =>[
                'ManagerTELTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'manager_TEL_count'),
                'ManagerTELToMonthCount' => $this->CheckCount($CheckCountExcavationBehaviorLog,'manager_TEL_count'),
                'MManagerTELToPeriodCount' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'manager_TEL_count'),
            ],

            '個人TEL' =>[
                'PersonalTELTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'personal_TEL_count'),
                'PersonalTELTodayMonthCount' => $this->CheckCount($CheckCountExcavationBehaviorLog,'personal_TEL_count'),
                'PersonalTELToPeriodCount' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'personal_TEL_count'),
            ],

            'ランダムTEL 実施' =>[
                'RandomTELTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'random_TEL_implementation_count'),
                'RandomTELTodayMonthCount' => $this->CheckCount($CheckCountExcavationBehaviorLog,'random_TEL_implementation_count'),
                'RandomTELToPeriodCount' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'random_TEL_implementation_count'),
            ],

            'ランダムTEL 在宅' => [
                'RandomTELAtHomeTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'random_TEL_at_home_count'),
                'RandomTELAtHomeTodayMonthCount' => $this->CheckCount($CheckCountExcavationBehaviorLog,'random_TEL_at_home_count'),
                'RandomTELAtHomeToPeriodCount' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'random_TEL_at_home_count'),
            ],

            '手紙・封書郵送' =>[
                'MailLetterTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'mail_letter_count'),
                'MailLetterTodayMonthCount' => $this->CheckCount($CheckCountExcavationBehaviorLog,'mail_letter_count'),
                'MailLetterToPeriodCount' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'mail_letter_count'),
            ],

            '売却チラシ宅配依頼' => [
                'FlyerDeliveryTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'flyer_delivery_count'),
                'FlyerDeliveryTodayMonthCount' => $this->CheckCount($CheckCountExcavationBehaviorLog,'flyer_delivery_count'),
                'FlyerDeliveryToPeriodCount' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'flyer_delivery_count'),
            ],

            'DM郵送' => [
                'DMMailTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'DM_mail_count'),
                'DMMailTodayMonthCount' => $this->CheckCount($CheckCountExcavationBehaviorLog,'DM_mail_count'),
                'DMMailToPeriodCount' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'DM_mail_count'),
            ],
        ];
    }

    //社内発掘を期間別に配列にして算出
    private function pre($TodayExcavationBehaviorLog, $CheckCountExcavationBehaviorLog, $HalfCheckCountExcavationBehaviorLog): array
    {
        return[
            '前取訪問 実施' =>[
                'preVisitTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'pre_visit_preliminary_count'),
                'preVisitToMonthCount' => $this->CheckCount($CheckCountExcavationBehaviorLog,'pre_visit_preliminary_count'),
                'preVisitToPeriodCount' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'pre_visit_preliminary_count'),
            ],

            '前取訪問 在宅' =>[
                'preVisitHomeTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'pre_visit_home_count'),
                'preVisitHomeTodayMonthCount' => $this->CheckCount($CheckCountExcavationBehaviorLog,'pre_visit_home_count'),
                'preVisitHomeToPeriodCount' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'pre_visit_home_count'),
            ],

            '前取TEL 在宅' =>[
                'preTELTodayCount' => $this->CheckCount($TodayExcavationBehaviorLog,'pre_TEL_home_count'),
                'preTELTodayMonthCount' => $this->CheckCount($CheckCountExcavationBehaviorLog,'pre_TEL_home_count'),
                'preTELToPeriodCount' => $this->CheckCount($HalfCheckCountExcavationBehaviorLog,'pre_TEL_home_count'),
            ],
        ];
    }

    //当月の発掘を戻す
    private function Today($request, $date)
    {
        return
            ExcavationBehaviorLog::where('user_id', $request->input('SearchUser'))
                ->whereDate('action_date', $date)
                ->get();
    }

    //当月の発掘を戻す
    private function ToMonth($request, $date)
    {
        return
            ExcavationBehaviorLog::where('user_id', $request->input('SearchUser'))
                ->whereYear('action_date', $date->year)
                ->whereMonth('action_date', $date->month)
                ->whereDay('action_date', '<=',$date->day)
                ->get();
    }

    //半期の発掘を戻す
    private function HalfPeriod($request, $date)
    {
        $baseExcavationBehaviorLog = ExcavationBehaviorLog::where('user_id', $request->input('SearchUser'));
        if (4 <= $date->month && $date->month <= 9){
            $StartCheckCount = Carbon::createMidnightDate($date->year, 4, 1);
            $EndCheckCount = $date;
            return $baseExcavationBehaviorLog->whereBetween('action_date', [$StartCheckCount, $EndCheckCount])->get();
        }elseif (10 <= $date->month){
            $StartCheckCount = Carbon::createMidnightDate($date->year, 10, 1);
            $EndCheckCount = $date;
            return $baseExcavationBehaviorLog->whereBetween('action_date', [$StartCheckCount, $EndCheckCount])->get();
        }elseif ($date->month <= 3) {
            $StartCheckCount = Carbon::createMidnightDate($date->year, 10, 1)->subYear();
            $EndCheckCount = $date;
            return $baseExcavationBehaviorLog->whereBetween('action_date', [$StartCheckCount, $EndCheckCount])->get();
        }
    }
    
    private function CheckCount($ExcavationBehaviorLog, $target_column)
    {
        return $ExcavationBehaviorLog->sum($target_column);
    }
}