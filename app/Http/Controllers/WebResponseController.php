<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\Analysis\WebResponse;

class WebResponseController extends Controller
{
    public function index(Request $request, WebResponse $webResponse)
    {
        return view('analysis.WebResponse.index', [
            'analysisData' => $webResponse($request),
            'request' => $request,
        ]);
    }
}
