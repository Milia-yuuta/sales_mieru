<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\UseCases\Client\StoreAction;
use App\UseCases\PropertyRoom\UpdateAction;

class ClientController extends Controller
{
    public function store(Request $request, StoreAction $storeAction, UpdateAction $UpdateAction)
    {
//        try {
            $client_id = $storeAction($request)->id;
            $request->merge(['client_id' => $client_id, 'property_id' => $request->input('property_id')]);
            $UpdateAction($request);
//        }catch(\Exception $e){
//            return back()->withInput()->with('flash_message', 'エラーが発生しました。');
//        }
        return back()->withInput()->with('flash_message', '登録に成功しました。');
    }
}
