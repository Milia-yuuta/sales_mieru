<?php

namespace App\UseCases\NextProspectActionLog;

use App\Models\NextProspectActionLog;

class StoreAction
{
    public function __invoke($request)
    {
        unset($request['user_id'], $request['stage_action_master_id'], $request['status_action_master_id'], $request['created_at'], $request['updated_at']);
        $NextProspectActionLogInstance = new NextProspectActionLog;
        $NextProspectActionLogInstance->fill($request)->save();
        return $NextProspectActionLogInstance;
    }

}
