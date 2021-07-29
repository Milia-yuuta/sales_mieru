<?php


namespace App\UseCases\ResultDailyReportActionLog\ProspectActionLogCount;

use App\UseCases\ResultDailyReportActionLog\ProspectActionLogCount\PeriodJudgment; 

class OvertCountAction extends PeriodJudgment
{
    public function __invoke(): array
    {
        $OvertToday = $this->ToDay()->where('stage_action_master_id', 3);
        $OvertToMonth = $this->ToMonth()->where('stage_action_master_id', 3);
        $OvertToPeriod = $this->Period()->where('stage_action_master_id', 3);

        return $this->ArrayInsert($OvertToday, $OvertToMonth, $OvertToPeriod);
    }

}