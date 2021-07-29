<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\ExcavationBehaviorLog\StoreAction;
use App\Http\Requests\ExcavationBehaviorLogRequest;
use App\UseCases\ExcavationBehaviorLog\SearchAction;

class ExcavationBehaviorLogController extends Controller
{
    public function store(ExcavationBehaviorLogRequest $request, StoreAction $storeAction)
    {
        try {
            $storeAction($request);
        } catch(\Exception $e){
            return back()->withInput()->with('flash_message', 'エラーが発生しました。');
        }
        return redirect()->back()->with('flash_message', '登録に成功しました。');
    }

    public function search(Request $request, SearchAction $SearchAction)
    {
        return response()->json($SearchAction($request));
    }
}
