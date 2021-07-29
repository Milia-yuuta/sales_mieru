<?php

namespace App\UseCases\Prospect;

use App\Models\Prospect;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class StoreAction
{
    public function __invoke($request): Prospect
    {
        $request->merge([
            'area_master_id' => Property::find($request->input('property_id'))->area_master_id,
            'office_master_id' => Auth::user()->office_master_id,
            'input_person' => Auth::user()->status_id,
            'latest_date' => $request->input('date'),
        ]);

        $prospect_instance = new Prospect;
        $prospect_instance->fill($request->all())->save();
        return $prospect_instance;
    }

}
