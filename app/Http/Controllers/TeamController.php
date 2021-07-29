<?php

namespace App\Http\Controllers;

use App\UseCases\Team\TeamSearchForOfficeAction;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function teamSearchForOffice($office_id, TeamSearchForOfficeAction $teamSearchForOfficeAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($teamSearchForOfficeAction($office_id));
    }
}
