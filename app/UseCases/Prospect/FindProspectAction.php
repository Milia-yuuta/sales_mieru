<?php


namespace App\UseCases\Prospect;
use App\Models\Prospect;

class FindProspectAction
{
    public function __invoke($request)
    {
        return
            Prospect::with('prospectActionLogs', 'nextProspectActionLogs', 'propertyRooms')->find($request->id);
    }

}