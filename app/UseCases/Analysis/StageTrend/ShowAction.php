<?php


namespace App\UseCases\Analysis\StageTrend;


use App\Models\PropertyRoom;

class ShowAction
{
    public function __invoke($prospect_id)
    {
        $propertyRoom = PropertyRoom::where('prospect_id', $prospect_id)->first();
        return [
            'id' => $prospect_id,
            'propertyName' => $propertyRoom->property->property_name,
            'roomName' => $propertyRoom->room_name,
        ];
    }
}