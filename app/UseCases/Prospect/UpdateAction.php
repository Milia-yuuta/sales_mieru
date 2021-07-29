<?php


namespace App\UseCases\Prospect;


use App\Models\Prospect;

class UpdateAction
{
    public function __invoke($request)
    {
        $prospect_instance = Prospect::find($request->prospect_id);
        $prospect_instance->fill($request->all())->save();
        if ($request->input('property_id')){
            $prospect_instance->propertyRooms->first()->fill(['property_id' => $request->input('property_id'), 'room_name' => $request->property_rooms['room_name']])->save();
        }
        return $prospect_instance;
    }
}