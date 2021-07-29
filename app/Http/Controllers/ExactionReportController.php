<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\Analysis\ExactionReportAction;

class ExactionReportController extends Controller
{
    public function index(Request $request, ExactionReportAction $ExactionReportAction)
    {
        return view('analysis.ExactionReport.index',[
            'analysisData' => $ExactionReportAction($request),
            'request' => $request,
        ]);
    }
}
