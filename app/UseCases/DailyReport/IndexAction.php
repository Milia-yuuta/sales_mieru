<?php


namespace App\UseCases\DailyReport;

use App\Models\DailyReport;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\Traits\Creator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class IndexAction
{
    public function __invoke($request): array
    {

        if ($request->filled('weekType')){
            $this->setWeeklyFeed($request);
        }

        //リクエストがNULLの時、当月にて検索
        if (!$request->filled('start_period')){
            $this->setDefaultStart($request);
        }

        if (!$request->filled('office')){
            $request = $request->merge([
                'office' => Auth::user()->office_master_id,
            ]);
        }

        $users = User::query()->where('users.office_master_id', $request->input('office'));

        if ($request->filled('area')){
            $users->where('sale_area_master_id', $request->input('area'))->orWhere('hat_area_master_id', $request->input('area'));
        }

        $request->merge([
            'user_id' => $users->pluck('id')
        ]);

        $dates = $this->dateGenerate($request);
        return $this->setUserForEach($request, $dates);
    }

    private function dateGenerate($request): array
    {
        $count = Carbon::create($request->input('start_period'))->diffInDays($request->input('end_period'));
        $period = CarbonPeriod::create($request->input('start_period'), $count+1);
        foreach ($period as $date){
            $dates[] = [
                'date' => $date->format('Y-m-d'),
            ];
        }
        return $dates;
    }

    private function setUserForEach($request, $dates): array
    {
        foreach ($request->input('user_id') as $user){
            unset($dailyReport, $dailyReports);
            foreach ($dates as $date){
                $dailyReport = DailyReport::query()
                    ->join('users', 'daily_reports.user_id', '=', 'users.id')
                    ->leftJoin('teams as sales', 'users.id', '=', 'sales.sales_id')
                    ->leftJoin('teams as hats', 'users.id', '=', 'hats.hat_id')
                    ->leftJoin('user_masters as offices', 'users.office_master_id', '=', 'offices.id')
                    ->select([
                        'daily_reports.*',
                        'offices.name',
                        'users.sei',
                        'users.mei',
                        'users.office_master_id',
                        'sales.area_master_id',
                        'hats.area_master_id'
                    ])
                    ->where('daily_reports.user_id', $user)
                    ->whereDate('daily_reports.date', $date['date'])
                    ->get();
                if ($dailyReport->isNotEmpty()){
                    $dailyReports[$user][] = [
                        'id' => $dailyReport->first()->id,
                        'user_id'=> $dailyReport->first()->user_id,
                        'name' => $dailyReport->first()->name,
                        'sei' => $dailyReport->first()->sei,
                        'mei' => $dailyReport->first()->mei,
                        'date' => $date['date'],
                        'reportDate' => $dailyReport->first()->date->format('Y-m-d'),
                        'plan_check' => $dailyReport->first()->plan_check,
                        'result_check' => $dailyReport->first()->result_check,
                        'unreachableDate' => $date['date'] > Carbon::now()->format('Y-m-d') ? 1 : 0,
                    ];
                }else{
                    $dailyReports[$user][] = [
                        'date' => $date['date'],
                        'unreachableDate' => $date['date'] > Carbon::now()->format('Y-m-d') ? 1 : 0,
                    ];
                }
            }
            $dailyReportList[] = $dailyReports;
        }
        return array_merge(['date' => $dates], ['reports' => $dailyReportList]);
    }

    private function setDefaultStart($request)
    {
        Carbon::now() >= Carbon::now()->startOfWeek() ? $start_point = 'this_week' : $start_point = 'last_week';
        return match ($start_point){
            'this_week' => $request->merge([
                'start_period' => Carbon::now()->startOfWeek()->format('Y-m-d'),
                'end_period' => Carbon::now()->startOfWeek()->addDay(6)->format('Y-m-d'),
            ]),
            'last_week' => $request->merge([
                'start_period' => Carbon::now()->startOfWeek()->subWeek(1)->addDay(3)->format('Y-m-d'),
                'end_period' => Carbon::now()->startOfWeek()->addDay(6)->format('Y-m-d'),
            ])
        };
    }

    //１週間毎を取得
    private function setWeeklyFeed($request)
    {
        $date = new Carbon($request->input('setDate'));

        return
            match ($request->input('weekType')){
                'sub' => $request->merge([
                    'start_period' => $date->subWeek(1)->format('Y-m-d'),
                    'end_period' => $date->addDay(6)->format('Y-m-d'),
                ]),
                'add' => $request->merge([
                    'start_period' => $date->addWeek(1)->format('Y-m-d'),
                    'end_period' => $date->addDay(6)->format('Y-m-d'),
                ])
            };
    }
}