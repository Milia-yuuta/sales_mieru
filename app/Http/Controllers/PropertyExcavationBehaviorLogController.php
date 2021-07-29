<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\PropertyExcavationBehaviorLog\StoreAction;
use App\UseCases\PropertyExcavationBehaviorLog\CountDownAction;
use App\UseCases\PropertyExcavationBehaviorLog\SearchAction;

class PropertyExcavationBehaviorLogController extends Controller
{
    public function store(Request $request, StoreAction $storeAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($storeAction($request));
    }

    public function CountDown(Request $request, CountDownAction $CountDownAction): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json($CountDownAction($request));
        } catch (\Exception $e) {
        }
    }

    public function search(SearchAction $SearchAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($SearchAction());
    }
}
