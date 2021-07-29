<?php

namespace App\UseCases\Analysis\TodayStock;

use App\Models\ActionMaster;
use App\Models\Prospect;
use App\Models\ProspectActionLog;
use App\Models\Team;
use App\Models\UserMaster;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TodayStockAction
{
    public function __invoke($request): ?array
    {
        //デフォルト画面でログインユーザーの事業所を表示するために
        if (empty($request->all())) {
            $request = $request->merge([
                'office_master_id' => \Auth::user()->office_master_id
            ]);
        }
        $OfficeTeam = $this->searchPair($request);
        if ($OfficeTeam->isEmpty()){
            return [];
        }
        //Prospect
        $NowProspect = Prospect::with('propertyRooms', 'prospectActionLogs')->where('office_master_id', $request->office_master_id)->where('date', '<', Carbon::now())
            ->get();

        //該当事業所の社員毎の追客状況
        foreach ($OfficeTeam->sortBy('area_master_id') as $value) {
            $ThisUserProspect = $NowProspect->where('area_master_id', $value->area_master_id);
            $analysis[$value->id] = [
                'id' => $value->id,
                'sale_id' => $value->sales_id,
                'sale_name' => $value->sale->sei,
                'hat_id' => $value->hat_id,
                'hat_name' => $value->hat->sei ?? '',
                'area_name' => ActionMaster::find($value->area_master_id)->action_name,
                'OfficeName' => UserMaster::find($request->input('office_master_id'))->name,
                'DiscriminationNoTELCount' => $this->StatusCount($ThisUserProspect, 5),
                'DiscriminationTELCount' => $this->StatusCount($ThisUserProspect, 6),
                'ShortLatentCount' => $this->StatusCount($ThisUserProspect, 8),
                'ActualThisOvertCount' => $this->StatusCount($ThisUserProspect, 12),
                'OvertMonthCount' => $this->StatusCount($ThisUserProspect, 11),

                'DiscriminationNoMeansCount' => $this->StatusCount($ThisUserProspect, 7),
                'LongLatentCount' => $this->StatusCount($ThisUserProspect, 9),
                'ActualThisLatentCount' => $this->StatusCount($ThisUserProspect, 10),
                'OvertNextSeasonCount' => $this->StatusCount($ThisUserProspect, 13),
                'FullServiceCount' => $this->StatusMediationCount($ThisUserProspect, 15),
                'panpyCount' => $this->StatusMediationCount($ThisUserProspect, 16),
                'sellerCount' => $this->StatusMediationCount($ThisUserProspect, 14),
                'exclusiveCount' => $this->StatusMediationCount($ThisUserProspect, 17)
            ];
            //トータル項目を作成
            $sum = $analysis[$value->id]['DiscriminationNoTELCount']
                + $analysis[$value->id]['DiscriminationTELCount']
                + $analysis[$value->id]['ShortLatentCount']
                + $analysis[$value->id]['ActualThisOvertCount']
                + $analysis[$value->id]['OvertMonthCount'];
            $analysis[$value->id] += ['totalCount' => $sum];
            $propertyByStatus = [];
        }
        $todayStock = array_merge(['analysis' => $analysis, 'propertyByStatus' => $propertyByStatus]);

        return $todayStock;
    }

    //事業所の社員IDを取得
    private function searchPair($request)
    {
        return Team::where('office_master_id', $request->input('office_master_id'))->get();
    }

    //ステータスカウント
    private function StatusCount($ThisUserProspect, $target_status_id): int
    {
        $count = 0;
        foreach ($ThisUserProspect as $prospect) {
            $prospectActionLog = $prospect
                ->prospectActionLogs
                ->sortBy('date')
                ->last();
            if (empty($prospectActionLog)) {
                $count += 0;
            } elseif ($prospectActionLog->status_action_master_id === $target_status_id) {
                ++$count;
            }
        }
        return $count;
    }

    //媒介ステータスカウント
    private function StatusMediationCount($ThisUserProspect, $target_status_id): int
    {
        $count = 0;
        foreach ($ThisUserProspect as $prospect) {
            $prospectActionLog = $prospect
                ->prospectActionLogs
                ->whereBetween('date', [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])
                ->sortBy('date')
                ->last();

            if (empty($prospectActionLog)) {
                $count += 0;
            } elseif ($prospectActionLog->status_action_master_id === $target_status_id) {
                ++$count;
            }
        }
        return $count;
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
            ];
        })->reject(fn ($room) => is_null($room))->all();
    }

    //ステータス別の部屋探索
    private function propertyMediationRoomsByStatus(Collection $ThisUserProspect, $target_status_id): array
    {
        return $ThisUserProspect->map(function ($prospect) use($target_status_id) {
            $latestLog = $prospect->prospectActionLogs->whereBetween('date', [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])
                ->sortBy('date')
                ->last();

            if (blank($latestLog) || $latestLog->status_action_master_id !== $target_status_id) {
                return null;
            }

            return [
//                'id' => $prospect->id,
//                'propertyName' => $latestLog->prospect->propertyRooms->first()->property->property_name,
//                'roomName' => $latestLog->prospect->propertyRooms->first()->room_name,
            ];
        })->reject(fn ($room) => is_null($room))->all();
    }

}