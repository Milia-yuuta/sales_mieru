<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use App\UseCases\Analysis\StageTrend\StageTrendAction;
use App\UseCases\Analysis\StageTrend\StageTrendPropertyRoomListAction;
use App\UseCases\Analysis\StageTrend\ShowAction;
use App\UseCases\Analysis\StageTrend\FootListReportAction;

class StageTrendController extends Controller
{
    public function index(Request $request, StageTrendAction $StageTrendAction)
    {
        return view ('analysis.stageTrend.index',[
            'request' => $request,
            'analysisData' => $StageTrendAction($request)
        ]);
    }

    public function roomList(Request $request, StageTrendPropertyRoomListAction $StageTrendPropertyRoomListAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($StageTrendPropertyRoomListAction($request));
    }

    public function show($prospect_id, ShowAction $showAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($showAction($prospect_id));
    }

    public function FootListReportAction($request, FootListReportAction $footListReportAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($footListReportAction($request));
    }
}
