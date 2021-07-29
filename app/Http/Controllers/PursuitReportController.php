<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\Analysis\Pursuit\PursuitReportAction;
use App\UseCases\Analysis\Pursuit\RoomListAction;

class PursuitReportController extends Controller
{
    public function index(Request $request, PursuitReportAction $PursuitReportAction)
    {
        return view('analysis.pursuitReport.index',[
            'analysisData' => $PursuitReportAction($request),
            'request' => $request,
        ]);
    }

    public function roomList(Request $request, RoomListAction $roomListAction)
    {
        return response()->json($roomListAction($request));
    }
}
