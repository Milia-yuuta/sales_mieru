<?php

namespace App\UseCases\PropertyRoom;

use App\Models\PropertyRoom;
use Illuminate\Pagination\LengthAwarePaginator;

class StoreAction
{
    public function __invoke($request)
    {
        $prospect_action_log_instance = new PropertyRoom;
        $prospect_action_log_instance->fill($request)->save();
    }
}
