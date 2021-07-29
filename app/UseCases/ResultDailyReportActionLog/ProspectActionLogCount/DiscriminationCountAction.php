<?php


namespace App\UseCases\ResultDailyReportActionLog\ProspectActionLogCount;

use App\UseCases\ResultDailyReportActionLog\ProspectActionLogCount\PeriodJudgment;

class DiscriminationCountAction extends PeriodJudgment
{
    public function __invoke():array
    {
        $DiscriminationToday = $this->ToDay()->where('stage_action_master_id', 1);
        $DiscriminationToMonth = $this->ToMonth()->where('stage_action_master_id', 1);
        $DiscriminationToPeriod = $this->Period()->where('stage_action_master_id', 1);

        return $this->ArrayInsert($DiscriminationToday, $DiscriminationToMonth, $DiscriminationToPeriod);
    }

}