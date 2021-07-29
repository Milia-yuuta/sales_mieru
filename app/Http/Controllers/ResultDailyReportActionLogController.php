<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\ResultDailyReportActionLog\ResultAction;

class ResultDailyReportActionLogController extends Controller
{
    public function index($id, ResultAction $ResultAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($ResultAction($id));
    }
}
