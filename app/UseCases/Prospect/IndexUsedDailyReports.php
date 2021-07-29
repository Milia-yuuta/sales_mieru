<?php


namespace App\UseCases\Prospect;

use App\Models\NextProspectActionLog;
use App\Models\Prospect;
use App\Models\ProspectActionLog;
use App\Models\User;
use Carbon\Carbon;
use http\Message\Body;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexUsedDailyReports
{
    public function __invoke($request, $date)
    {
        $prospects = Prospect::with([
            'nextProspectActionLogs' => function($query) use ($date){
                $query->where('next_action_date', '<=', $date)
                    ->orderbyDesc('next_action_date');
            },'propertyRooms.property','prospectActionLogs'
        ])
            ->where('date','<=',$date->endofday())
            ->where('office_master_id', User::find($request->SearchUser)->office_master_id)
            ->whereIn('area_master_id', User::find($request->SearchUser)->AllAreaSearch)
            ->whereHas('nextProspectActionLogs', function ($query) use($date){
                $query->where('next_action_date', '<=', $date)
                ;
            })
            ->whereHas('ProspectActionLogs', function ($query){
                $query->where('stage_action_master_id', '<', 4);
            })
            ->get();
        return $prospects;
    }

}