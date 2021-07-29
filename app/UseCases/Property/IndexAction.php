<?php

namespace App\UseCases\Property;

use App\Models\Property;
use App\Models\PropertyExcavationBehaviorLog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexAction
{
    public function __invoke($request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $property_excavation_behavior_logs = PropertyExcavationBehaviorLog::query()->whereDate('action_date', Carbon::now()->format('Y-m-d'))->where('user_id', Auth::user()->id);
        $property_instance = Property::query()
            ->join('prefecture_masters', 'prefecture_master_id', '=', 'prefecture_masters.id')
            ->leftJoin('property_favorites', 'properties.id', '=', 'property_favorites.property_id')
            ->leftJoinSub($property_excavation_behavior_logs, 'property_excavation_behavior_logs', function ($query) {
                $query->on('properties.id', '=', 'property_excavation_behavior_logs.property_id');
            })
            ->select([
                'properties.*',
                'prefecture_masters.name',
                DB::raw('properties.nearest_station_walk_time + properties.bus_stop_walk_time as total_time'),
                DB::raw('CONCAT(properties.prefecture_master_id, prefecture_masters.name, properties.address1, properties.address2) as full_address'),
                'property_favorites.id as property_favorites_id',
                'property_excavation_behavior_logs.manager_visit_count',
                'property_excavation_behavior_logs.manager_TEL_count',
                'property_excavation_behavior_logs.check_building_count',
            ])
            ->orderBy('property_favorites_id', 'DESC');

        //デフォルト検索
        if (empty($request->all())){
            $request->merge([
                'office_master_id' => Auth::user()->office_master_id,
                'area_master_id' => $this->areaSearch()->first(),
            ]);
        }

        if (isset($request->office_master_id)){
            $property_instance = $property_instance
                ->where('properties.office_master_id', $request->input('office_master_id'));
        }

//        if (isset($request->area_master_id)){
//            $property_instance = $property_instance
//                ->orderBy('created_at', 'DESC')
//                ->whereIn('properties.area_master_id', $request->area_master_id);
//        }

        if (isset($request->area_master_id) && $request->area_master_id > 0){
            $property_instance = $property_instance
                ->where('properties.area_master_id', $request->area_master_id);
        }

        //キーワード検索
        if (isset($request->SearchWord)){
            $property_instance->where(function ($query) use ($request){
                $query->Where('properties.property_name', 'LIKE', "%$request->SearchWord%")
                    ->orWhere('prefecture_masters.name', 'LIKE', "%$request->SearchWord%")
                    ->orWhere('properties.address1', 'LIKE', "%$request->SearchWord%")
                    ->orWhere('properties.address2', 'LIKE', "%$request->SearchWord%");
            });
        }

        //ソート機能
        switch ($request->input('PropertyNameSort')) {
            case 1:
                $property_instance->orderBy('properties.property_name', 'ASC');
                break;
            case 2:
                $property_instance->orderBy('properties.property_name', 'DESC');
                break;
        }

        switch ($request->input('PropertyAddressSort')) {
            case 1:
                $property_instance->orderBy('full_address', 'ASC');
                break;
            case 2:
                $property_instance->orderBy('full_address', 'DESC');
                break;
        }

        switch ($request->input('PropertyAccessSort')) {
            case 1:
                $property_instance->orderBy('total_time', 'ASC');
                break;
            case 2:
                $property_instance->orderBy('total_time', 'DESC');
                break;
        }

        switch ($request->input('PropertyBuildingDateSort')) {
            case 1:
                $property_instance->orderBy('properties.date_completion', 'ASC');
                break;
            case 2:
                $property_instance->orderBy('properties.date_completion', 'DESC');
                break;
        }

        switch ($request->input('PropertyUnitSort')) {
            case 1:
                $property_instance->orderBy('properties.total_unit', 'ASC');
                break;
            case 2:
                $property_instance->orderBy('properties.total_unit', 'DESC');
                break;
        }

        switch ($request->input('PropertyVisitSort')) {
            case 1:
                $property_instance->orderBy('property_excavation_behavior_logs.manager_visit_count', 'ASC');
                break;
            case 2:
                $property_instance->orderBy('property_excavation_behavior_logs.manager_visit_count', 'DESC');
                break;
        }

        switch ($request->input('PropertyTelSort')) {
            case 1:
                $property_instance->orderBy('property_excavation_behavior_logs.manager_TEL_count', 'ASC');
                break;
            case 2:
                $property_instance->orderBy('property_excavation_behavior_logs.manager_TEL_count', 'DESC');
                break;
        }

        switch ($request->input('PropertyCheckSort')) {
            case 1:
                $property_instance->orderBy('property_excavation_behavior_logs.check_building_count', 'ASC');
                break;
            case 2:
                $property_instance->orderBy('property_excavation_behavior_logs.check_building_count', 'DESC');
                break;
        }

        //項目選択
        return $property_instance->paginate(200);
    }

    protected function areaSearch()
    {
        if (Auth::user()->sales->isNotEmpty()){
            return Auth::user()->sales->pluck('area_master_id');
        }else{
            return Auth::user()->hats->pluck('area_master_id');

        }
    }
}