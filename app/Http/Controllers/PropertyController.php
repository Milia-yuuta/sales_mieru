<?php

namespace App\Http\Controllers;

use App\Models\PropertyFavorite;
use Illuminate\Http\Request;
use App\UseCases\Property\IndexAction as SearchProperties;
use App\UseCases\User\SearchUserSelect2Action as SearchUserSelect2;
use App\Http\Requests\PropertyRequest;
use App\UseCases\Property\StoreAction;
use App\UseCases\Property\PinAction;
use App\UseCases\Property\PinDeleteAction;
use App\UseCases\Property\StageSearchAction;
use App\UseCases\Property\NameListAction;
use App\UseCases\Property\CodeListAction;
use App\UseCases\Property\SearchByCodeAction;

class PropertyController extends Controller{

    public function index(Request $request, SearchProperties $searchProperties, SearchUserSelect2 $SearchUserSelect2)
    {
        return view('property.index', [
            'searchProperties' => $searchProperties($request),
            'request' => $request ,
            'SearchUserSelect2' => $SearchUserSelect2(),
        ]);
    }

    public function store(PropertyRequest $request,StoreAction $StoreAction): \Illuminate\Http\RedirectResponse
    {
        try {
            $StoreAction($request);
        } catch(\Exception $e){
            return back()->withInput()->with('flash_message', 'エラーが発生しました。');
        }
        return redirect()->route('property')->with('flash_message', '登録に成功しました。');
    }

    public function pin(Request $request, PinAction $pinAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($pinAction($request)->id);
    }

    public function pinDelete(Request $request, PinDeleteAction $PinDeleteAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($PinDeleteAction($request));
    }

    public function StageSearch(Request $request, StageSearchAction $StageSearchAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($StageSearchAction($request));
    }

    public function nameList(Request $request ,NameListAction $nameListAction)
    {
        return response()->json($nameListAction($request));
    }

    public function codeList(Request $request, CodeListAction $codeListAction)
    {
        return response()->json($codeListAction($request));
    }

    public function SearchByCode($property_id, SearchByCodeAction $searchByCodeAction)
    {
        return response()->json($searchByCodeAction($property_id));
    }
}
