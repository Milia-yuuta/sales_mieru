<?php


namespace App\UseCases\Property;
use App\Models\Property;
use App\Models\ProspectActionLog;

class StageSearchAction
{
    public function __invoke($request): array
    {
        $latestActionLog = ProspectActionLog::query()->selectRaw('prospect_id, max(id) as id')->groupBy('prospect_id');
        $latestActionLogSelect = ProspectActionLog::whereIn('id', $latestActionLog->get()->pluck('id'));

        return Property::query()
            ->join('property_rooms', 'properties.id', '=', 'property_rooms.property_id')
            ->join('prospects', 'property_rooms.prospect_id', '=', 'prospects.id')
            ->leftJoinSub($latestActionLogSelect, 'latest_action_log', function ($join) {
                $join->on('prospects.id', '=', 'latest_action_log.prospect_id');
            })
            ->groupBy('properties.id','prospects.id', 'latest_action_log.id')
            ->select(['properties.id', 'property_rooms.room_name', 'properties.property_name','prospects.id as prospect_id', 'latest_action_log.stage_action_master_id'])
            ->where('properties.id', $request->property_id)
            ->where('latest_action_log.stage_action_master_id', $request->stage_action_master_id)
            ->get()
            ->toArray();
    }
}