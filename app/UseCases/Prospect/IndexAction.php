<?php

namespace App\UseCases\Prospect;

use App\Models\Prospect;
use App\Models\ProspectActionLog;
use Carbon\Carbon;
use http\Message\Body;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class IndexAction
{
    public function __invoke($request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $latestActionLog = ProspectActionLog::query()->orderByDesc('date')->orderByDesc('id')->get()->groupBy('prospect_id');
        if ($latestActionLog->isEmpty()){
            $ids[] = NULL;
        }
        foreach ($latestActionLog as $log){
            $ids[] = $log->first()->id;
        }
        $latestActionLogSelect = ProspectActionLog::whereIn('id', $ids);

        $prospectActionLogs = ProspectActionLog::query()
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->where('prospect_action_logs.TEL_home', 1)
            ->orWhere('prospect_action_logs.send_letter', 1)
            ->orWhere('prospect_action_logs.local_letter', 1)
            ->orWhere('prospect_action_logs.email', 1)
            ->orWhere('prospect_action_logs.visit', 1)
            ->orWhere('prospect_action_logs.pursuit_other', 1)
            ->orWhere('prospect_action_logs.assessment_report_email', 1)
            ->orWhere('prospect_action_logs.send_assessment_report', 1)
            ->orWhere('prospect_action_logs.web_negotiation', 1)
            ->orWhere('prospect_action_logs.assessment_negotiation', 1)
            ->orWhere('prospect_action_logs.re-negotiation', 1)
            ->orWhere('prospect_action_logs.visit_caretaker', 1)
            ->orWhere('prospect_action_logs.TEL_caretaker', 1)
            ->orWhere('prospect_action_logs.on-site_check', 1)
            ->orWhere('prospect_action_logs.research_other', 1)
            ->orWhere('prospect_action_logs.re_TEL', 1)
            ->orWhere('prospect_action_logs.re_email', 1)
            ->orWhere('prospect_action_logs.re_letter', 1)
            ->orWhere('prospect_action_logs.re_hp', 1)
            ->orWhere('prospect_action_logs.re_site', 1)
            ->orWhere('prospect_action_logs.re_other', 1)
            ->get()->groupBy('prospect_id');
        unset($ids);
        if ($prospectActionLogs->isEmpty()){
            $ids[] = NULL;
        }
        foreach ($prospectActionLogs as $log){
            $ids[] = $log->first()->id;
        }
        if ($ids === NULL){
            $prospectActionLogsSubQuery = NULL;
        }else{
            $prospectActionLogsSubQuery = ProspectActionLog::whereIn('id', $ids);
        }

        $prospectInstance = Prospect::query()
            ->leftJoinSub($latestActionLogSelect, 'latest_action_log', function ($join) {
                $join->on('prospects.id', '=', 'latest_action_log.prospect_id');
            })
            ->leftJoinSub($prospectActionLogsSubQuery, 'prospect_action_logs', function ($join){
                $join->on('prospects.id', '=', 'prospect_action_logs.prospect_id');
            })
            ->leftJoin('next_prospect_action_logs', 'latest_action_log.id', '=', 'next_prospect_action_logs.prospect_action_log_id')
            ->leftJoin('prospect_favorites', 'prospects.id', '=', 'prospect_favorites.prospect_id')
            ->leftJoin('property_rooms', 'prospects.id', '=', 'property_rooms.prospect_id')
            ->leftJoin('properties', 'property_rooms.property_id', '=', 'properties.id')
            ->leftJoin('prefecture_masters', 'properties.prefecture_master_id', '=', 'prefecture_masters.id')
            ->leftJoin('action_masters as generating_medium_action', 'prospects.generating_medium_master_id', '=', 'generating_medium_action.id')
            ->groupBy('prospects.id', 'latest_action_log.id', 'property_rooms.id', 'prospect_favorites.id')
            ->select([
                'prospects.*',
                'latest_action_log.stage_action_master_id',
                'latest_action_log.id as latest_action_log_id',
                'latest_action_log.status_action_master_id',
                'latest_action_log.created_at as latest_action_log_created_at',
                'latest_action_log.updated_at as latest_action_log_updated_at',
                'latest_action_log.date as latest_action_log_date',
                DB::raw('DATEDIFF(CURDATE()+0, latest_action_log.date)  as latest_action_log_stage_stay_date'),
                'latest_action_log.result',
                'prospect_action_logs.date as last_action_date',
                'prospect_action_logs.id as last_action_date_id',
                'properties.property_name',
                'properties.address1',
                'properties.address2',
                'property_rooms.room_name',
                'prospect_favorites.id as prospect_favorites_id',
                'prospect_favorites.prospect_id as prospect_favorites_prospect_id',
                'prefecture_masters.name as prefecture_name',
                'next_prospect_action_logs.id as next_prospect_action_log_id',
                'next_prospect_action_logs.next_action_date',
                DB::raw('CONCAT(properties.prefecture_master_id, prefecture_masters.name, properties.address1, properties.address2) as full_address'),
                'generating_medium_action.action_name as generating_medium_name',
            ])
            ->where('latest_action_log.stage_action_master_id', '<', 4)
            ->orderBy('prospect_favorites_prospect_id', 'DESC');

        //キーワード検索
        if (isset($request->SearchWord)) {
            $prospectInstance->Where(function ($query) use ($request){
                $query->where('properties.property_name', 'LIKE', "%$request->SearchWord%")
                    ->orWhere('properties.address1', 'LIKE', "%$request->SearchWord%")
                    ->orWhere('properties.address2', 'LIKE', "%$request->SearchWord%")
                    ->orWhere('prospects.remark', 'LIKE', "%$request->SearchWord%")
                    ->orWhere('generating_medium_action.action_name', 'LIKE', "%$request->SearchWord%")
                ;
            });
        }

        //ステージ絞り込み
        if (isset($request->stage) && $request->stage >= 1 ) {
            $prospectInstance = $prospectInstance->where('latest_action_log.stage_action_master_id', $request->input('stage'));
        }

        //ステータス絞り込み
        if (isset($request->status) && $request->status >= 1) {
            $prospectInstance = $prospectInstance->where('latest_action_log.status_action_master_id', $request->input('status'));
        }

        //事業所検索
        if (isset($request->office)) {
            $prospectInstance->Where('prospects.office_master_id', $request->office);
        }

        //エリア検索
        if (isset($request->area) && $request->area >= 1) {
            $prospectInstance->Where('prospects.area_master_id',  $request->area);
        }
        if (empty($request->StageSort) &&
            empty($request->PropertyNameSort) &&
            empty($request->ProspectDateSort) &&
            empty($request->LastProspectActionLogSort) &&
            empty($request->StageStayDateSort) &&
            empty($request->NextActionDateSort) &&
            empty($request->ProspectsRoomSort) &&
            empty($request->StatusSort) &&
            empty($request->AddressSort)
        ){
            $prospectInstance->orderBy('latest_action_log.date', 'DESC');
            $prospectInstance->orderBy('latest_action_log.created_at', 'DESC');
        }

        //ソート機能
        switch ($request->input('StageSort')) {
            case 1:
                $prospectInstance->orderBy('latest_action_log.stage_action_master_id', 'ASC');
                break;
            case 2:
                $prospectInstance->orderBy('latest_action_log.stage_action_master_id', 'DESC');
                break;
        }

        switch ($request->input('PropertyNameSort')) {
            case 1:
                $prospectInstance->orderBy('properties.property_name', 'ASC');
                break;
            case 2:
                $prospectInstance->orderBy('properties.property_name', 'DESC');
                break;
        }

        switch ($request->input('ProspectDateSort')) {
            case 1:
                $prospectInstance->orderBy('prospects.date', 'ASC');
                break;
            case 2:
                $prospectInstance->orderBy('prospects.date', 'DESC');
                break;
        }

        switch ($request->input('LastProspectActionLogSort')) {
            case 1:
                $prospectInstance->orderBy('last_action_date', 'DESC');
                break;
            case 2:
                $prospectInstance->orderBy('last_action_date', 'ASC');
                break;
        }

        switch ($request->input('StageStayDateSort')) {
            case 1:
                $prospectInstance->orderBy('latest_action_log_stage_stay_date', 'ASC');
                break;
            case 2:
                $prospectInstance->orderBy('latest_action_log_stage_stay_date', 'DESC');
                break;
        }

        switch ($request->input('NextActionDateSort')) {
            case 1:
                $prospectInstance->orderBy('next_prospect_action_logs.next_action_date', 'ASC');
                break;
            case 2:
                $prospectInstance->orderBy('next_prospect_action_logs.next_action_date', 'DESC');
                break;
        }

        switch ($request->input('ProspectsRoomSort')) {
            case 1:
                $prospectInstance->orderBy('property_rooms.room_name', 'ASC');
                break;
            case 2:
                $prospectInstance->orderBy('property_rooms.room_name', 'DESC');
                break;
        }

        switch ($request->input('StatusSort')){
            case 1:
                $prospectInstance->orderBy('latest_action_log.status_action_master_id', 'ASC');
                break;
            case 2:
                $prospectInstance->orderBy('latest_action_log.status_action_master_id', 'DESC');
                break;
        }

        switch ($request->input('AddressSort')){
            case 1:
                $prospectInstance->orderBy('full_address', 'ASC');
                break;
            case 2:
                $prospectInstance->orderBy('full_address', 'DESC');
                break;
        }

        //入替時にバーを表示
        if (empty($request->display_address) &&
            empty($request->display_generating_medium) &&
            empty($request->display_date) &&
            empty($request->display_reaction) &&
            empty($request->display_assessment)
        ){
            $request->merge(['default' => 'check']);
        }
        return $prospectInstance->paginate(50);
    }
}
