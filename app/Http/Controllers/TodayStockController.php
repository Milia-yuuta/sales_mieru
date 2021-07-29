<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\Analysis\TodayStock\TodayStockAction;
use App\UseCases\Analysis\TodayStock\GetRoomsAction;
use App\UseCases\Analysis\TodayStock\HomeGetRoomsAction;
use App\UseCases\Analysis\TodayStock\PropertyInformationAction;

class TodayStockController extends Controller
{
    public function index(Request $request, TodayStockAction $TodayStockAction)
    {
        return view('analysis.todayStock.index',[
            'analysisDate' => $TodayStockAction($request),
            'request' => $request->merge(['office_master_id' => $request->input('office_master_id')])
        ]);
    }

    public function getRooms(GetRoomsAction $getRoomsAction, $office_id)
    {
        return response()->json($getRoomsAction($office_id));
    }

    public function homeGetRooms(HomeGetRoomsAction $getRoomsAction, $office_id)
    {
        return response()->json($getRoomsAction($office_id));
    }

    public function view(GetRoomsAction $getRoomsAction, $office_id)
    {
        return view('analysis.todayStock.test',[
            'analysisDate' => $getRoomsAction($office_id)
        ]);
    }

    public function show($prospect_id, PropertyInformationAction $propertyInformationAction)
    {
        return response()->json($propertyInformationAction($prospect_id));
    }
}