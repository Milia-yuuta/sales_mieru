<?php

namespace App\Http\Controllers;


use App\Models\NextProspectActionLog;
use App\Models\ProspectActionLog;
use Illuminate\Http\Request;
use App\Http\Requests\ProspectActoinLogRequest;
use App\UseCases\ProspectActionLog\StoreAction;
use App\UseCases\ProspectActionLog\UpdateAction;
use App\UseCases\NextProspectActionLog\StoreAction as NextStoreAction;
use App\UseCases\NextProspectActionLog\UpdateAction as NextUpdateAction;
use App\UseCases\ProspectActionLog\DeleteAction as prospectActionLogDelete;
use App\UseCases\NextProspectActionLog\DeleteActon as nextProspectActionLogDelete;

class ProspectActionLogController extends Controller
{
    public function store(ProspectActoinLogRequest $request, StoreAction $storeAction, NextStoreAction $NextStoreAction): \Illuminate\Http\RedirectResponse
    {
        $nextActionCheck = NextProspectActionLog::where('prospect_id', $request->next['prospect_id'])->whereDate('next_action_date', $request->next['next_action_date'])->get();
        if ($nextActionCheck->isNotEmpty()){
            return back()->withInput()->with('flash_error', '既に同日に予定があります。');
        }

        if (ProspectActionLog::where('prospect_id', $request->prospect_id)->get()->first()->date > $request->date){
            return back()->withInput()->with('flash_error', '見込発生日より前の日付で入力されています。');
        }
        if (ProspectActionLog::where('prospect_id', $request->prospect_id)->get()->first()->date > $request->next['next_action_date'] && $request->next['next_action_date']){
            return back()->withInput()->with('flash_error', '見込発生日より前の日付で入力されています。');
        }
        try {
            $ProspectActionLogId = $storeAction($request->all())->id;
            $NextProspectActionLogArray = array_merge($request->next, ['prospect_action_log_id' => $ProspectActionLogId]);
            $NextStoreAction($NextProspectActionLogArray);
        }catch(\Exception $e){
            return back()->withInput()->with('flash_message', 'エラーが発生しました。');
        }
        return back()->withInput()->with('flash_message', '登録に成功しました。');
    }

    public function update(ProspectActoinLogRequest $request, UpdateAction $UpdateAction, NextUpdateAction $NextUpdateAction): \Illuminate\Http\RedirectResponse
    {
        $nextActionCheck = NextProspectActionLog::where('id', '!=', $request->next['NextProspectActionLog_id'])->where('prospect_id', $request->next['prospect_id'])->whereDate('next_action_date', $request->next['next_action_date'])->get();
        if ($nextActionCheck->isNotEmpty()){
            return back()->withInput()->with('flash_error', '既に同日に予定があります。');
        }
        if (ProspectActionLog::where('prospect_id', $request->prospect_id)->get()->first()->date > $request->date && ProspectActionLog::where('prospect_id', $request->prospect_id)->get()->first()->id != $request->ProspectActionLog_id){
            return back()->withInput()->with('flash_error', '見込発生日より前の日付で入力されています。');
        }
        if (ProspectActionLog::where('prospect_id', $request->prospect_id)->get()->first()->date > $request->next['next_action_date'] && $request->next['next_action_date']){
            return back()->withInput()->with('flash_error', '見込発生日より前の日付で入力されています。');
        }
        try {
            $UpdateAction($request);
            $NextUpdateAction($request);
        }catch(\Exception $e){
            return back()->withInput()->with('flash_message', 'エラーが発生しました。');
        }
        return back()->withInput()->with('flash_message', '登録に成功しました。');
    }

    public function delete(Request $request, prospectActionLogDelete $prospectActionLogDelete, nextProspectActionLogDelete $nextProspectActionLogDelete): \Illuminate\Http\RedirectResponse
    {
        try {
            $prospectActionLogDelete($request);
            $nextProspectActionLogDelete($request);
        }catch(\Exception $e){
            return back()->withInput()->with('flash_message', 'エラーが発生しました。');
        }
        return back()->withInput()->with('flash_message', '削除に成功しました。');
    }
}
