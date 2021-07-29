<?php


namespace App\UseCases\Analysis\TodayStock;

use App\Models\Prospect;
use App\Models\Team;
use Carbon\Carbon;

class GetRoomsAction
{
    public function __invoke($office_id)
    {
        //デフォルト画面でログインユーザーの事業所を表示するために
        $OfficeTeam = $this->searchPair($office_id);
        //Prospect
        $NowProspect = Prospect::with(['propertyRooms.property', 'prospectActionLogs'])
            ->where('office_master_id', $office_id)
            ->where('date', '<', Carbon::now())
            ->get();

        //該当事業所の社員毎の追客状況
        foreach ($OfficeTeam->sortBy('area_master_id') as $value) {
            $ThisUserProspect = $NowProspect->where('area_master_id', $value->area_master_id);

            $propertyByStatus[$value->id] = [
                'DiscriminationNoTELCount' => $this->propertyRoomsByStatus($ThisUserProspect, 5),
                'DiscriminationTELCount' => $this->propertyRoomsByStatus($ThisUserProspect, 6),
                'ShortLatentCount' => $this->propertyRoomsByStatus($ThisUserProspect, 8),
                'ActualThisOvertCount' => $this->propertyRoomsByStatus($ThisUserProspect, 12),
                'OvertMonthCount' => $this->propertyRoomsByStatus($ThisUserProspect, 11),
                'DiscriminationNoMeansCount' => $this->propertyRoomsByStatus($ThisUserProspect, 7),
                'LongLatentCount' => $this->propertyRoomsByStatus($ThisUserProspect, 9),
                'ActualThisLatentCount' => $this->propertyRoomsByStatus($ThisUserProspect, 10),
                'OvertNextSeasonCount' => $this->propertyRoomsByStatus($ThisUserProspect, 13),
                'FullServiceCount' => $this->propertyMediationRoomsByStatus($ThisUserProspect, 15),
                'panpyCount' => $this->propertyMediationRoomsByStatus($ThisUserProspect, 16),
                'sellerCount' => $this->propertyMediationRoomsByStatus($ThisUserProspect, 14),
                'exclusiveCount' => $this->propertyMediationRoomsByStatus($ThisUserProspect, 17),
            ];
        }
        return $propertyByStatus;
    }

    //事業所の社員IDを取得
    private function searchPair($office_id)
    {
        return Team::where('office_master_id', $office_id)->get();
    }

    //ステータス別の部屋探索
    private function propertyRoomsByStatus($ThisUserProspect, $target_status_id): array
    {
        return $ThisUserProspect->map(function (Prospect $prospect) use($target_status_id) {
            $latestLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();

            if (blank($latestLog) || $latestLog->status_action_master_id !== $target_status_id) {
                return null;
            }

            return [
                'id' => $prospect->id,
            ];
        })->reject(fn ($room) => is_null($room))->all();
    }

    //ステータス別の部屋探索
    private function propertyMediationRoomsByStatus($ThisUserProspect, $target_status_id): array
    {
        return $ThisUserProspect->map(function ($prospect) use($target_status_id) {
            $latestLog = $prospect->prospectActionLogs->whereBetween('date', [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])
                ->sortBy('date')
                ->last();

            if (blank($latestLog) || $latestLog->status_action_master_id !== $target_status_id) {
                return null;
            }

            return [
                'id' => $prospect->id,
//                'propertyName' => $prospect->propertyRoom->property->property_name,
//                'roomName' => $prospect->propertyRoom->room_name,
            ];
        })->reject(fn ($room) => is_null($room))->all();
    }
}