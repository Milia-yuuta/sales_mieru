<?php


namespace App\UseCases\ResultDailyReportActionLog\ProspectActionLogCount;

use App\UseCases\ResultDailyReportActionLog\ProspectActionLogCount\PeriodJudgment;

class LatentCountAction extends PeriodJudgment
{
    public function __invoke(): array
    {
        $LatentToday = $this->ToDay()->where('stage_action_master_id', 2);
        $LatentToMonth = $this->ToMonth()->where('stage_action_master_id', 2);
        $LatentToPeriod = $this->Period()->where('stage_action_master_id', 2);

        return $this->ArrayInsert($LatentToday, $LatentToMonth, $LatentToPeriod);
    }

}