<?php


namespace App\UseCases\NextProspectActionLog;

use App\Models\NextProspectActionLog;

class UpdateAction
{
    public function __invoke($request)
    {
        $NextProspectActionLogInstance =  NextProspectActionLog::find($request->next['NextProspectActionLog_id']);
        return $NextProspectActionLogInstance->fill($request->next)->save();
    }
}
