<?php


namespace App\UseCases\NextProspectActionLog;
use App\Models\NextProspectActionLog;

class DeleteActon
{
    public function __invoke($request)
    {
        return NextProspectActionLog::find($request->input('next_prospect_action_log_id'))->forceDelete();
    }
}