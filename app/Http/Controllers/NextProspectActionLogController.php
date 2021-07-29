<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\NextProspectActionLog\resultUpdateAction;

class NextProspectActionLogController extends Controller
{
    public function resultUpdate(Request $request, resultUpdateAction $resultUpdateAction)
    {
        return response()->json($resultUpdateAction($request));
    }
}
