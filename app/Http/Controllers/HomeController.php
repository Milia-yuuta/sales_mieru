<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Carbon\Carbon;
use App\UseCases\DailyReportActionLog\PlanAction;
use App\UseCases\Analysis\TodayStock\HomeTodayStockAction;
use App\Models\DailyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request, PlanAction $PlanAction, HomeTodayStockAction $TodayStockAction)
    {
        //TodayStockActionの中からログインユーザーの配列を取得
        $TodayStocks = $TodayStockAction($request);
        $team_ids = Auth::user()->AllAreaSearchIds;

        $TodayStock = [];
        if (!empty($TodayStocks) && $team_ids->isNotEmpty()) {
            foreach ($team_ids->sortBy('area_master_id') as $team_id) {
                $TodayStock[$team_id]['analysis'] = $TodayStocks['analysis'][$team_id];
                $TodayStock[$team_id]['propertyByStatus'] = $TodayStocks['propertyByStatus'][$team_id];
            }
        }

        $id = NULL;
        $dailyReport = DailyReport::query()->where('user_id', Auth::user()->id)->whereDate('date', Carbon::now())->get();
        if ($dailyReport->isNotEmpty()){
            $id = $dailyReport->first()->id;
        }

        return view('index', [
            'dailyReport' =>  $dailyReport->first(),
            'PlanTimeList' => $PlanAction($id),
            'TodayStock' => $TodayStock,
        ]);
    }

    public function damy(Request $request, PlanAction $PlanAction, homeTodayStockAction $TodayStockAction)
    {
        //TodayStockActionの中からログインユーザーの配列を取得
        $TodayStocks = $TodayStockAction($request);
        $team_ids = Auth::user()->AllAreaSearchIds;

        $TodayStock = [];
        if (!empty($TodayStocks) && $team_ids->isNotEmpty()) {
            foreach ($team_ids->sortBy('area_master_id') as $team_id) {
                $TodayStock[$team_id]['analysis'] = $TodayStocks['analysis'][$team_id];
                $TodayStock[$team_id]['propertyByStatus'] = $TodayStocks['propertyByStatus'][$team_id];
            }
        }

        $id = NULL;
        $dailyReport = DailyReport::query()->where('user_id', Auth::user()->id)->whereDate('date', Carbon::now())->get();
        if ($dailyReport->isNotEmpty()){
            $id = $dailyReport->first()->id;
        }

        return view('damyHome', [
            'dailyReport' =>  $dailyReport->first(),
            'PlanTimeList' => $PlanAction($id),
            'TodayStock' => $TodayStock,
        ]);
    }
}
