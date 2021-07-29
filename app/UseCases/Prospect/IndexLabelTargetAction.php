<?php

namespace App\UseCases\Prospect;

use App\Models\Prospect;
use App\Models\ProspectActionLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class IndexLabelTargetAction
{
    public function __invoke($request): LengthAwarePaginator
    {
        $latestActionLog = ProspectActionLog::query()->orderByDesc('date')->orderByDesc('id')->get()
            ->groupBy('prospect_id');
        if ($latestActionLog->isEmpty()) {
            $ids[] = null;
        }
        foreach ($latestActionLog as $log) {
            $ids[] = $log->first()->id;
        }
        $latestActionLogSelect = ProspectActionLog::whereIn('id', $ids);

        $prospectInstance = Prospect::query()
            ->leftJoinSub($latestActionLogSelect, 'latest_action_log', function ($join) {
                $join->on('prospects.id', '=', 'latest_action_log.prospect_id');
            })
            ->leftJoin('next_prospect_action_logs', 'latest_action_log.id', '=', 'next_prospect_action_logs.prospect_action_log_id')
            ->leftJoin('prospect_favorites', 'prospects.id', '=', 'prospect_favorites.prospect_id')
            ->leftJoin('action_masters as stage_masters', 'latest_action_log.stage_action_master_id', '=', 'stage_masters.id')
            ->leftJoin('action_masters as status_masters', 'latest_action_log.status_action_master_id', '=', 'status_masters.id')
            ->leftJoin('property_rooms', 'prospects.id', '=', 'property_rooms.prospect_id')
            ->leftJoin('clients', 'property_rooms.client_id', '=', 'clients.id')
            ->leftJoin('properties', 'property_rooms.property_id', '=', 'properties.id')
            ->join('prefecture_masters', 'properties.prefecture_master_id', '=', 'prefecture_masters.id')
            ->leftJoin('action_masters as usage_action', 'prospects.usage_action_master_id', '=', 'usage_action.id')
            ->leftJoin('action_masters as generating_medium_action', 'prospects.generating_medium_master_id', '=', 'generating_medium_action.id')
            ->groupBy('prospects.id', 'latest_action_log.id', 'property_rooms.id', 'prospect_favorites.id')
            ->select([
                'prospects.*',
                'latest_action_log.stage_action_master_id',
                'latest_action_log.status_action_master_id',
                'latest_action_log.date as latest_action_log_date',
                DB::raw('DATEDIFF(CURDATE()+0, latest_action_log.date) + latest_action_log.stage_stay_date as latest_action_log_stage_stay_date'),
                DB::raw('DATEDIFF(CURDATE()+0, latest_action_log.date) as prospect_action_log_stage_stay_date'),
                'properties.property_name',
                'property_rooms.room_name',
                'properties.date_completion',
                'property_rooms.id as property_room_id',
                'property_rooms.occupied_area',
                'clients.name as client_name',
                'stage_masters.action_name as stage_name',
                'status_masters.action_name as status_name',
            ])
            ->where('latest_action_log.stage_action_master_id', '<', 4);

        //ステージ絞り込み
        if (isset($request->stage) && $request->stage >= 1) {
            $prospectInstance = $prospectInstance->where('latest_action_log.stage_action_master_id', $request->input('stage'));
        }

        //ステータス絞り込み
        if (isset($request->status) && $request->status >= 1) {
            $prospectInstance = $prospectInstance->where('latest_action_log.status_action_master_id', $request->input('status'));
        }

        //キーワード検索
        if (isset($request->SearchWord)) {
            $prospectInstance->Where('properties.property_name', 'LIKE', "%$request->SearchWord%")
                ->orWhere('properties.address1', 'LIKE', "%$request->SearchWord%")
                ->orWhere('properties.address2', 'LIKE', "%$request->SearchWord%")
                ->orWhere('prospects.remark', 'LIKE', "%$request->SearchWord%")
                ->orWhere('usage_action.action_name', 'LIKE', "%$request->SearchWord%")
                ->orWhere('generating_medium_action.action_name', 'LIKE', "%$request->SearchWord%");
        }

        //事業所検索
        if (isset($request->office)) {
            $prospectInstance->Where('prospects.office_master_id', $request->office);
        }

        //デフォルトのエリア検索
        //        if (!empty($request->user_area)) {
        //            $prospectInstance->WhereIn('prospects.area_master_id',  $request->user_area);
        //        }

        //エリア検索
        if (isset($request->area) && $request->area >= 1) {
            $prospectInstance->Where('prospects.area_master_id', $request->area);
        }

        if (empty($request->StageSort) &&
            empty($request->PropertyNameSort) &&
            empty($request->ProspectsUsageSort) &&
            empty($request->ProspectDateSort) &&
            empty($request->LastProspectActionLogSort) &&
            empty($request->StageStayDateSort) &&
            empty($request->NextActionDateSort) &&
            empty($request->ProspectsRoomSort) &&
            empty($request->StatusSort) &&
            empty($request->PropertyOccupiedAreaSort) &&
            empty($request->PropertyCompletionDateSort)
        ) {
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


        switch ($request->input('StatusSort')) {
            case 1:
                $prospectInstance->orderBy('latest_action_log.status_action_master_id', 'ASC');
                break;
            case 2:
                $prospectInstance->orderBy('latest_action_log.status_action_master_id', 'DESC');
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


        switch ($request->input('ProspectsRoomSort')) {
            case 1:
                $prospectInstance->orderBy('property_rooms.room_name', 'ASC');
                break;
            case 2:
                $prospectInstance->orderBy('property_rooms.room_name', 'DESC');
                break;
        }


        switch ($request->input('ClientSort')) {
            case 1:
                $prospectInstance->orderBy('clients.name', 'ASC');
                break;
            case 2:
                $prospectInstance->orderBy('clients.name', 'DESC');
                break;
        }


        switch ($request->input('LastProspectActionLogSort')) {
            case 1:
                $prospectInstance->orderBy('latest_action_log.date', 'DESC');
                break;
            case 2:
                $prospectInstance->orderBy('latest_action_log.date', 'ASC');
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


        switch ($request->input('PropertyOccupiedAreaSort')) {
            case 1:
                $prospectInstance->orderBy('property_rooms.occupied_area', 'ASC');
                break;
            case 2:
                $prospectInstance->orderBy('property_rooms.occupied_area', 'DESC');
                break;
        }

        switch ($request->input('PropertyCompletionDateSort')) {
            case 1:
                $prospectInstance->orderBy('properties.date_completion', 'ASC');
                break;
            case 2:
                $prospectInstance->orderBy('properties.date_completion', 'DESC');
                break;
        }

        return $prospectInstance->paginate(50);
    }
}
