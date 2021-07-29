<?php


namespace App\UseCases\ResultDailyReportActionLog;

use App\Models\ResultDailyReportActionLog;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

class ResultAction
{
    public function __invoke($id): array
    {
        $searchDailyReportActionLog = ResultDailyReportActionLog::with('actionMaster.actionMaster', 'dailyReport')->where('daily_report_id', $id)->get();
        $timeList = [];

        if ($searchDailyReportActionLog->isEmpty()){
            return $timeList;
        }

        $timeList['date'] = $searchDailyReportActionLog->first()->dailyReport->date->format('Y-m-d');
        $timeList['schedule'] = $searchDailyReportActionLog->map(function($actionLog) {
            return [
                'start' => Carbon::parse($actionLog->dailyReport->date->format('Y-m-d').' '.$actionLog->start_time)->format(DateTime::ATOM),
                'end' => Carbon::parse($actionLog->dailyReport->date->format('Y-m-d').' '.$actionLog->end_time)->format(DateTime::ATOM),
                'title' => $actionLog->actionMaster->action_name,
                'calendarId' => $actionLog->actionMaster->actionMaster->id,
                'state' => $actionLog->action_master_id,
                'category' => 'time',
                'id' => $actionLog->id,
                'color' => 'white',
                'bgColor' => $this->colorSelect($actionLog->actionMaster->actionMaster->id),
                'borderColor' => 'white',
            ];
        });
        return $timeList;
    }

    private function colorSelect($action_id): string
    {
        switch ($action_id){
            case '18':
                return '#5DAC81';
            case '19':
                return '#51A8DD';
            case '20':
                return '#FB966E';
            case '21':
                return '#F6C555';
            case '22':
                return '#CCCCFF';
            case '23':
                return '#FEDFE1';
        }
    }
}
