<?php


namespace App\UseCases\ResultDailyReportActionLog;

use App\Models\DailyReport;
use App\Models\ResultDailyReportActionLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ActiveTime
{
    public function __invoke($request, $date): array
    {
        return array_merge(['ToMonth' => $this->ToMonthArray($request, $date)], ['HalfPeriod' => $this->HalfPeriodArray($request, $date)]);
    }

    private function ToMonthArray($request, $date): array
    {
        $ToMonthArea = [
            'A' => $this->CheckTime( $this->ToMonth($request, $date), 24),
            'B' => $this->CheckTime( $this->ToMonth($request, $date), 25),
            'C' => $this->CheckTime( $this->ToMonth($request, $date), 26),
            'D' => $this->CheckTime( $this->ToMonth($request, $date), 27),
            'E' => $this->CheckTime( $this->ToMonth($request, $date), 28),
            'F' => $this->CheckTime( $this->ToMonth($request, $date), 29),
            'G' => $this->CheckTime( $this->ToMonth($request, $date), 30),
            'H' => $this->CheckTime( $this->ToMonth($request, $date), 31),
        ];
        $ToMonthArea['total'] = $this->total($ToMonthArea);

        $ToMonthOffice = [
            'PurchasingWork' => $this->CheckTime($this->ToMonth($request, $date), 32),
            'OfficeWork' => $this->CheckTime($this->ToMonth($request, $date), 33),
        ];
        $ToMonthOffice['total'] = $this->total($ToMonthOffice);

        $ToMonthOpportunity = [
            'web' => $this->CheckTime($this->ToMonth($request, $date), 34),
            'opportunity' => $this->CheckTime($this->ToMonth($request, $date), 35),
            'ReOpportunity' => $this->CheckTime($this->ToMonth($request, $date), 36),
        ];
        $ToMonthOpportunity['total'] = $this->total($ToMonthOpportunity);

        $ToMonthMeeting = [
            'OfficeMeeting' =>  $this->CheckTime($this->ToMonth($request, $date), 37),
            'training' => $this->CheckTime($this->ToMonth($request, $date), 38),
        ];
        $ToMonthMeeting['total'] = $this->total($ToMonthMeeting);

        $ToMonthSale = [
            'sale' => $this->CheckTime($this->ToMonth($request, $date), 39),
            'agreement' => $this->CheckTime($this->ToMonth($request, $date), 40),
            'payment' => $this->CheckTime($this->ToMonth($request, $date), 41),
        ];
        $ToMonthSale['total'] = $this->total($ToMonthSale);

        $ToMonthOther = [
            'other' =>  $this->CheckTime($this->ToMonth($request, $date), 42),
        ];

        return array_merge(['ToMonthArea' => $ToMonthArea], ['ToMonthOffice' => $ToMonthOffice], ['ToMonthOpportunity' => $ToMonthOpportunity], ['ToMonthMeeting' => $ToMonthMeeting], ['ToMonthSale' => $ToMonthSale], ['ToMonthOther' => $ToMonthOther]);
    }

    private function HalfPeriodArray($request, $date): array
    {
        $HalfPeriodArea = [
            'A' => $this->CheckTime( $this->HalfPeriod($request, $date), 24),
            'B' => $this->CheckTime( $this->HalfPeriod($request, $date), 25),
            'C' => $this->CheckTime( $this->HalfPeriod($request, $date), 26),
            'D' => $this->CheckTime( $this->HalfPeriod($request, $date), 27),
            'E' => $this->CheckTime( $this->HalfPeriod($request, $date), 28),
            'F' => $this->CheckTime( $this->HalfPeriod($request, $date), 29),
            'G' => $this->CheckTime( $this->HalfPeriod($request, $date), 30),
            'H' => $this->CheckTime( $this->HalfPeriod($request, $date), 31),
        ];
        $HalfPeriodArea['total'] = $this->total($HalfPeriodArea);

        $HalfPeriodOffice = [
            'PurchasingWork' => $this->CheckTime($this->HalfPeriod($request, $date), 32),
            'OfficeWork' => $this->CheckTime($this->HalfPeriod($request, $date), 33),
        ];
        $HalfPeriodOffice['total'] = $this->total($HalfPeriodOffice);

        $HalfPeriodOpportunity = [
            'web' => $this->CheckTime($this->HalfPeriod($request, $date), 34),
            'opportunity' => $this->CheckTime($this->HalfPeriod($request, $date), 35),
            'ReOpportunity' => $this->CheckTime($this->HalfPeriod($request, $date), 36),
        ];
        $HalfPeriodOpportunity['total'] = $this->total($HalfPeriodOpportunity);

        $HalfPeriodMeeting = [
            'OfficeMeeting' =>  $this->CheckTime($this->HalfPeriod($request, $date), 37),
            'training' => $this->CheckTime($this->HalfPeriod($request, $date), 38),
        ];
        $HalfPeriodMeeting['total'] = $this->total($HalfPeriodMeeting);

        $HalfPeriodSale = [
            'sale' => $this->CheckTime($this->HalfPeriod($request, $date), 39),
            'agreement' => $this->CheckTime($this->HalfPeriod($request, $date), 40),
            'payment' => $this->CheckTime($this->HalfPeriod($request, $date), 41),
        ];
        $HalfPeriodSale['total'] = $this->total($HalfPeriodSale);

        $HalfPeriodOther = [
            'other' =>  $this->CheckTime($this->HalfPeriod($request, $date), 42),
        ];

        return array_merge(['HalfPeriodArea' => $HalfPeriodArea], ['HalfPeriodOffice' => $HalfPeriodOffice], ['HalfPeriodOpportunity' => $HalfPeriodOpportunity], ['HalfPeriodMeeting' => $HalfPeriodMeeting], ['HalfPeriodSale' => $HalfPeriodSale], ['HalfPeriodOther' => $HalfPeriodOther]);
    }

    //当月のDailyReportを戻す
    private function ToMonth($request, $date)
    {
        return
            DailyReport::where('user_id', $request->input('SearchUser'))
                ->whereYear('date', $date->year)
                ->whereMonth('date', $date->month)
                ->whereDay('date', '<=', $date->day);
    }

    //半期のDailyReportを戻す
    private function HalfPeriod($request, $date)
    {
        $baseDailyReport = DailyReport::where('user_id', $request->input('SearchUser'));
        if (4 <= $date->month && $date->month <= 9){
            $StartPeriod = Carbon::createMidnightDate($date->year, 4, 1);
            $EndPeriod = $date;
            return $baseDailyReport->whereBetween('date', [$StartPeriod, $EndPeriod]);
        }elseif (10 <= $date->month){
            $StartPeriod = Carbon::createMidnightDate($date->year, 10, 1);
            $EndPeriod = $date;
            return $baseDailyReport->whereBetween('date', [$StartPeriod, $EndPeriod]);
        }elseif ($date->month <= 3) {
            $StartPeriod = Carbon::createMidnightDate($date->year, 10, 1)->subYear();
            $EndPeriod = $date;
            return $baseDailyReport->whereBetween('date', [$StartPeriod, $EndPeriod]);
        }
    }

    //ステータス毎の時間を計算
    private function CheckTime($ToMonthDailyReports, $stage_id)
    {
        $DailyReportsByStatus = $ToMonthDailyReports->leftJoinSub($this->subQuesry($stage_id), 'action_log', function ($join){
            $join->on('daily_reports.id', '=', 'action_log.daily_report_id');
        })
            ->select('daily_reports.*', DB::raw('SUBTIME(action_log.end_time, action_log.start_time) as worked_time'))
            ->get();

        if ($DailyReportsByStatus->isEmpty()){
            return 0;
        }

        $time = 0;
        foreach ($DailyReportsByStatus as $dailyReports){
            $times = array_map('intval', explode(':', $dailyReports->worked_time));
            if (count($times) === 0){
                return $time;
            }elseif(count($times) > 1){
                $time += $times[0] + $times[1] / 60;
            }
        }
        return $time;
    }

    private function subQuesry($stage_id)
    {
        return
            ResultDailyReportActionLog::where('action_master_id', $stage_id);
    }

    //配列の合計値を計算
    private function total($arrary)
    {
        $count = 0;
        if (empty($arrary))return 0;
        foreach ($arrary as $individual){
            $count += $individual;
        }
        return $count;
    }
}