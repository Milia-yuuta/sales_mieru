<?php

namespace App\Http\Controllers;


use App\Models\Prospect;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\DailyReport;

use App\UseCases\DailyReport\IndexAction;
use App\UseCases\Prospect\IndexUsedDailyReports as ProspectIndex;
use App\UseCases\DailyReport\StoreAction;
use App\UseCases\DailyReport\EditAction;
use App\UseCases\DailyReportActionLog\PlanAction;
use App\UseCases\ResultDailyReportActionLog\ResultAction;
use App\UseCases\DailyReportActionLog\PlanStoreAction as PlanStore;
use App\UseCases\DailyReportActionLog\PlanUpdate;
use App\UseCases\ResultDailyReportActionLog\ResultStoreAction as ResultStore;
use App\UseCases\ResultDailyReportActionLog\ResultUpdate;
use App\UseCases\Prospect\analysisUsedInDailyReports;
use App\UseCases\ResultDailyReportActionLog\ActiveTime;
use App\UseCases\ExcavationBehaviorLog\analysisUsedInDailyReports as ExcavationBehaviorLogAnalysis;
use App\UseCases\ProspectActionLog\analysisUsedInDailyReports as ProspectActionLogAnalysis;
use App\Http\Requests\DailyReportRequest;
use App\Http\Requests\DailyReportActionLogRequst;
use App\UseCases\DailyReportActionLog\DeleteAction as planDeleteAction;
use App\UseCases\ResultDailyReportActionLog\DeleteAction as resultDeleteAction;
use App\UseCases\User\UserSearchByOfficeAction;
use Illuminate\Support\Facades\Auth;


class DailyReportController extends Controller
{
    public function index(Request $request, IndexAction $IndexAction)
    {
        if ($request->office) {
            $checkTeam = Team::where('office_master_id', $request->office)->get();
            if ($checkTeam->isEmpty()) {
                return redirect()->route('home')->withInput()->with('flash_error', '該当事業所にエリア担当者が不在です。');
            }
        }

        return view('dailyReport.index',
                [
                        'request'         => $request,
                        'DailyReportList' => $IndexAction($request),
                ]);
    }


    public function create()
    {
        return view('dailyReport.create');
    }


    public function store(DailyReportRequest $request, StoreAction $storeAction): \Illuminate\Http\RedirectResponse
    {
        if (DailyReport::where('user_id', $request->input('user_id'))->whereDate('date', $request->input('date'))->get()
                       ->isNotEmpty()) {
            return back()->withInput()->with('flash_error', '同日の日報が既に登録されています。');
        }
        try {
            $dailyReportId = $storeAction($request)->id;
        } catch (\Exception $e) {
            return back()->withInput()->with('flash_error', 'エラーが発生しました。');
        }

        return redirect()->route('dailyReport.show', $dailyReportId)->with('flash_message', '登録に成功しました。');
    }


    //リファクタリング作業保留
    public function show(
            Request $request,
            $id,
            PlanAction $planAction,
            ResultAction $ResultAction,
            ProspectIndex $ProspectIndex,
            analysisUsedInDailyReports $analysisUsedInDailyReports,
            ActiveTime $activeTime,
            ExcavationBehaviorLogAnalysis $ExcavationBehaviorLogAnalysis,
            ProspectActionLogAnalysis $ProspectActionLogAnalysis
    )
    {
        //スケジュール欄で使用
        $dailyReport = DailyReport::find($id);
        $user_id = $dailyReport->user_id;
        $request = $request->merge(['SearchUser' => $user_id]);
        $date = $dailyReport->date;


        return view('dailyReport.show',
                [
                        'request'                       => $request,
                        'dailyReport'                   => $dailyReport,
                        'PlanTimeList'                  => $planAction($id),
                        'ResultTimeList'                => $ResultAction($id),
                        'ProspectList'                  => $ProspectIndex($request, $date),
                        'analysisUsedInDailyReports'    => $analysisUsedInDailyReports($user_id, $date),
                        'activeTime'                    => $activeTime($request, $date),
                        'ExcavationBehaviorLogAnalysis' => $ExcavationBehaviorLogAnalysis($request, $date),
                        'ProspectActionLogAnalysis'     => $ProspectActionLogAnalysis($request, $date),
                        'date'                          => $date,
                ]);
    }


    public function edit(Request $request, EditAction $editAction): \Illuminate\Http\RedirectResponse
    {
        try {
            $editAction($request);
        } catch (\Exception $e) {
            return back()->withInput()->with('flash_error', 'エラーが発生しました。');
        }

        return redirect()->route('dailyReport')->with('flash_message', '登録に成功しました。');
    }


    public function PlanStore(DailyReportActionLogRequst $request, PlanStore $PlanStore): \Illuminate\Http\RedirectResponse
    {
        if (str_replace(':', '', $request->input('start_time')) > str_replace(':', '', $request->input('end_time'))) {
            return back()->withInput()->with('flash_error', '開始時間が終了時間を超えています。');
        }
        try {
            $PlanStore($request);
        } catch (\Exception $e) {
            return back()->withInput()->with('flash_error', 'エラーが発生しました。');
        }

        return back()->withInput()->with('flash_message', '登録に成功しました。');
    }


    public function PlanUpdate(DailyReportActionLogRequst $request, PlanUpdate $PlanUpdate): \Illuminate\Http\RedirectResponse
    {
        try {
            $PlanUpdate($request);
        } catch (\Exception $e) {
            return back()->withInput()->with('flash_error', 'エラーが発生しました。');
        }

        return back()->withInput()->with('flash_message', '予定を変更しました。');
    }


    public function PlanDelete(Request $request, planDeleteAction $planDeleteAction)
    {
        try {
            $planDeleteAction($request);
        } catch (\Exception $e) {
            return back()->withInput()->with('flash_error', 'エラーが発生しました。');
        }

        return back()->withInput()->with('flash_message', '削除に成功しました。');
    }


    public function ResultStore(DailyReportActionLogRequst $request, ResultStore $ResultStore): \Illuminate\Http\RedirectResponse
    {
        if (str_replace(':', '', $request->input('start_time')) > str_replace(':', '', $request->input('end_time'))) {
            return back()->withInput()->with('flash_error', '開始時間が終了時間を超えています。');
        }
        try {
            $ResultStore($request);
        } catch (\Exception $e) {
            return back()->withInput()->with('flash_error', 'エラーが発生しました。');
        }

        return back()->withInput()->with('flash_message', '登録に成功しました。');
    }


    public function ResultUpdate(DailyReportActionLogRequst $request, ResultUpdate $ResultUpdate): \Illuminate\Http\RedirectResponse
    {
        try {
            $ResultUpdate($request);
        } catch (\Exception $e) {
            return back()->withInput()->with('flash_error', 'エラーが発生しました。');
        }

        return back()->withInput()->with('flash_message', '予定を変更しました。');
    }


    public function ResultDelete(Request $request, resultDeleteAction $resultDeleteAction)
    {
        try {
            $resultDeleteAction($request);
        } catch (\Exception $e) {
            return back()->withInput()->with('flash_error', 'エラーが発生しました。');
        }

        return back()->withInput()->with('flash_message', '結果を削除しました。');
    }


    public function ajaxPlanUpdate(Request $request, PlanUpdate $PlanUpdate): \Illuminate\Http\JsonResponse
    {
        return response()->json($PlanUpdate($request));
    }


    public function ajaxResultUpdate(Request $request, ResultUpdate $ResultUpdate): \Illuminate\Http\JsonResponse
    {
        return response()->json($ResultUpdate($request));
    }


    public function userSearch($office_id, UserSearchByOfficeAction $UserSearchByOfficeAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($UserSearchByOfficeAction($office_id));
    }
}
