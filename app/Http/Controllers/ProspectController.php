<?php

namespace App\Http\Controllers;

use App\Models\ProspectFavorite;
use Illuminate\Http\Request;
use App\UseCases\Prospect\IndexAction as searchProspects;
use App\UseCases\Prospect\StoreAction;
use App\UseCases\Prospect\UpdateAction;
use App\UseCases\Prospect\ShowAction;
use App\UseCases\Prospect\DeleteAction;
use App\UseCases\Prospect\PinAction;
use App\UseCases\Prospect\PinDeleteActon;
use App\UseCases\ProspectActionLog\StoreAction as ProspectActionLogStore;
use App\UseCases\PropertyRoom\StoreAction as PropertyRoomStore;
use App\UseCases\NextProspectActionLog\StoreAction as NextProspectActionLogStore;
use App\UseCases\Prospect\RequestSetUseInIndexAction;
use App\Http\Requests\ProspectRequest;
use App\UseCases\Prospect\FindProspectAction;
use App\UseCases\ProspectActionLog\DateChangeAction;

class ProspectController extends Controller
{
    public function index(Request $request, searchProspects $searchProspects, RequestSetUseInIndexAction $RequestSetUseInIndexAction)
    {
        $request = $RequestSetUseInIndexAction($request);
        $searchProspects = $searchProspects($request);
        return view('prospect.index',
            [
                'request' => $request,
                'searchProspects' => $searchProspects,
            ]);
    }

    public function store(ProspectRequest $request, StoreAction $storeAction, ProspectActionLogStore $ProspectActionLogStore,
                          PropertyRoomStore $PropertyRoomStore, NextProspectActionLogStore $NextProspectActionLogStore): \Illuminate\Http\RedirectResponse
    {
        try {
            $prospectInstanceId = $storeAction($request)->id;
            //Prospect(親キー)を配列へ挿入
            $request->merge([
                'prospect_action_logs' => [
                    'prospect_id' => $prospectInstanceId,
                    'user_id' => $request->input('user_id'),
                    'stage_action_master_id' => $request->prospect_action_logs['stage_action_master_id'],
                    'status_action_master_id' => $request->prospect_action_logs['status_action_master_id'],
                    'date' => $request->input('date')
                ],
                'property_rooms' => [
                    'prospect_id' => $prospectInstanceId,
                    'room_name' => $request->property_rooms['room_name'],
                    'property_id' => $request->property_id
                ]
            ]);
            //ディレクトリ構造を考慮し関連テーブルへの保存を分離
            $ProspectActionLogSaveData = $ProspectActionLogStore($request->input('prospect_action_logs'))->toArray();
            $PropertyRoomStore($request->input('property_rooms'));
            $ProspectActionLogSaveData['prospect_action_log_id'] = $ProspectActionLogSaveData['id'];
            $NextProspectActionLogStore($ProspectActionLogSaveData);
        }catch(\Exception $e){
            return back()->withInput()->with('flash_message', 'エラーが発生しました。');
        }
        return back()->withInput()->with('flash_message', '登録に成功しました。');
    }

    public function update(ProspectRequest $request, UpdateAction $UpdateAction, DateChangeAction $DateChangeAction): \Illuminate\Http\RedirectResponse
    {
        try {
            $UpdateAction($request);
            $DateChangeAction($request);
        }catch(\Exception $e){
            return back()->withInput()->with('flash_message', 'エラーが発生しました。');
        }
        return back()->withInput()->with('flash_message', '登録に成功しました。');
    }

    public function show(Request $request, ShowAction $ShowAction, FindProspectAction $FindProspectAction)
    {
        if (empty($FindProspectAction($request)->propertyRooms)){
            return redirect()->route('home')->withInput()->with('flash_error', '削除されたデータです。');
        }
        return view('prospect.show',
            [
                'request' => $request,
                'FindProspectArray' => $ShowAction($request),
                'firstProspect' => $FindProspectAction($request),
                'property' => $FindProspectAction($request)->propertyRooms->first()->property,
            ]);
    }

    public function delete(Request $request, $id, DeleteAction $DeleteAction): \Illuminate\Http\RedirectResponse
    {
        try {
            $DeleteAction($id);
        }catch(\Exception $e) {
            return back()->withInput()->with('flash_message', 'エラーが発生しました。');
        }return redirect()->route('prospect')->with('flash_message', '削除に成功しました。');
    }

    public function pin(Request $request, PinAction $pinAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($pinAction($request)->id);
    }

    public function pinDelete(Request $request, PinDeleteActon $pinDeleteActon): \Illuminate\Http\JsonResponse
    {
        return response()->json($pinDeleteActon($request));
    }

}
