<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\DailyReportActionLog\PlanAction;

class DailyReportActionLogController extends Controller
{
    public function index($id, PlanAction $planAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($planAction($id));
    }
}
