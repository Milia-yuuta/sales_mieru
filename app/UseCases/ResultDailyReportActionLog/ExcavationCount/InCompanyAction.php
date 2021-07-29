<?php


namespace App\UseCases\ResultDailyReportActionLog\ExcavationCount;

use App\UseCases\ResultDailyReportActionLog\ExcavationCount\PeriodJudgment;

class InCompanyAction extends PeriodJudgment
{
    public function __invoke():array
    {
        return[
            '管理人TEL' =>[
                'ManagerTELTodayCount' => $this->ToDay()->sum('manager_TEL_count'),
                'ManagerTELToMonthCount' => $this->ToMonth()->sum('manager_TEL_count'),
                'MManagerTELToPeriodCount' => $this->Period()->sum('manager_TEL_count'),
            ],

            '個人TEL' =>[
                'PersonalTELTodayCount' => $this->ToDay()->sum('personal_TEL_count'),
                'PersonalTELTodayMonthCount' => $this->ToMonth()->sum('personal_TEL_count'),
                'PersonalTELToPeriodCount' => $this->Period()->sum('personal_TEL_count'),
            ],

            'ランダムTEL 実施' =>[
                'RandomTELTodayCount' => $this->ToDay()->sum('random_TEL_implementation_count'),
                'RandomTELTodayMonthCount' => $this->ToMonth()->sum('random_TEL_implementation_count'),
                'RandomTELToPeriodCount' => $this->Period()->sum('random_TEL_implementation_count'),
            ],

            'ランダムTEL 在宅' => [
                'RandomTELAtHomeTodayCount' => $this->ToDay()->sum('random_TEL_at_home_count'),
                'RandomTELAtHomeTodayMonthCount' => $this->ToMonth()->sum('random_TEL_at_home_count'),
                'RandomTELAtHomeToPeriodCount' => $this->Period()->sum('random_TEL_at_home_count'),
            ],

            '手紙・封書郵送' =>[
                'MailLetterTodayCount' => $this->ToDay()->sum('mail_letter_count'),
                'MailLetterTodayMonthCount' => $this->ToMonth()->sum('mail_letter_count'),
                'MailLetterToPeriodCount' => $this->Period()->sum('mail_letter_count'),
            ],

            '売却チラシ宅配依頼' => [
                'FlyerDeliveryTodayCount' => $this->ToDay()->sum('flyer_delivery_count'),
                'FlyerDeliveryTodayMonthCount' => $this->ToMonth()->sum('flyer_delivery_count'),
                'FlyerDeliveryToPeriodCount' => $this->Period()->sum('flyer_delivery_count'),
            ],

            'DM郵送' => [
                'DMMailTodayCount' => $this->ToDay()->sum('DM_mail_count'),
                'DMMailTodayMonthCount' => $this->ToMonth()->sum('DM_mail_count'),
                'DMMailToPeriodCount' => $this->Period()->sum('DM_mail_count'),
            ],
        ];
    }

}