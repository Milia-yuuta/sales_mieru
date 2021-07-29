<?php

namespace App\Http\Controllers;

use App\Models\UserMaster;
use Illuminate\Http\Request;
use App\UseCases\Analysis\MonthlyResultAction;
use App\UseCases\Team\TeamArrayReturnAction;
use App\UseCases\Analysis\MonthlyResult\OfficeReportAction;
use App\UseCases\Analysis\MonthlyResult\IndividualReportAction;

class MonthlyResultController extends Controller
{
    public function index(Request $request, TeamArrayReturnAction $TeamArrayReturnAction, OfficeReportAction $OfficeReportAction, IndividualReportAction $IndividualReportAction)
    {
        return view('analysis.MonthlyResult.index',[
            'officeReport' => $OfficeReportAction($request),
            'individualReport' => $IndividualReportAction($request),
            'request' => $request,
            'TeamArrayReturnAction' => $TeamArrayReturnAction($request),
            'userMaster' => new UserMaster,
        ]);
    }
}
