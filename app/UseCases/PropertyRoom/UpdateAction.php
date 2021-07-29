<?php


namespace App\UseCases\PropertyRoom;
use App\Models\PropertyRoom;

class UpdateAction
{
    public function __invoke($request)
    {
        $propertyRoomInstance = PropertyRoom::query()->where('prospect_id', $request->prospect_id)->get()->first();
        $propertyRoomInstance->fill([
            'client_id' => $request->client_id
        ])->save();
    }
}