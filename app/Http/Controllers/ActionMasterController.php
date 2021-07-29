<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\ActionMaster\GeneratingMediumAction;
use App\UseCases\ActionMaster\StatusChangeAction;
use App\UseCases\ActionMaster\dailyReportAction;

class ActionMasterController extends Controller
{
    //見込みフォームの発生媒体の非同期で使用
    public function GeneratingMedium($medium, GeneratingMediumAction $GeneratingMediumAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($GeneratingMediumAction($medium));
    }

    //ステージに応じてステータスを配列で返却
    public function StatusChange($stage, StatusChangeAction $StatusChangeAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($StatusChangeAction($stage));
    }

    //日報の小項目を返却
    public function dailyReportAction(dailyReportAction $dailyReportAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($dailyReportAction());
    }
}
