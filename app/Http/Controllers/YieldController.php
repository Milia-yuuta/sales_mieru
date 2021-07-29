<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\Analysis\YieldReport\OfficeReportAction;
use App\UseCases\Analysis\YieldReport\IndividualAction;

class YieldController extends Controller
{
    public function index(Request $request, OfficeReportAction $OfficeReportAction, IndividualAction $IndividualAction)
    {
        return view('analysis.yield.index',[
            'officeReport' => $OfficeReportAction($request),
            'individualReport' => $IndividualAction($request),
            'request' => $request,
        ]);
    }
}
