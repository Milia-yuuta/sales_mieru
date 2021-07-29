<?php


namespace App\UseCases\PropertyRoom;


use Closure;
use App\Models\PropertyRoom;


class IndexToCsvAction
{
    public function __invoke(array $propertyRoomIds, ?Closure $proxy = null)
    {
        $propertyRooms = PropertyRoom::with(['property', 'client'])->find($propertyRoomIds);

        return filled($proxy)
                ? $proxy($propertyRooms->all())
                : $propertyRooms;
    }
}