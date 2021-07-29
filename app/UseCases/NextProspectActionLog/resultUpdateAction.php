<?php


namespace App\UseCases\NextProspectActionLog;

use App\Models\NextProspectActionLog;

class resultUpdateAction
{
    public function __invoke($request)
    {
        return NextProspectActionLog::find($request->input('id'))->fill($request->all())->save();
    }
}