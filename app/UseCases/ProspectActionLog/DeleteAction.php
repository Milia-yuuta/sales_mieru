<?php


namespace App\UseCases\ProspectActionLog;
use App\Models\ProspectActionLog;

class DeleteAction
{
    public function __invoke($request)
    {
        return ProspectActionLog::find($request->input('prospect_action_log_id'))->forceDelete();
    }
}