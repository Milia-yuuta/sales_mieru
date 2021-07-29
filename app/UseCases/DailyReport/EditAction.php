<?php


namespace App\UseCases\DailyReport;

use App\Models\DailyReport;

class EditAction
{
    public function __invoke($request): bool
    {
        return DailyReport::find($request->input('id'))->fill($request->all())->save();
    }
}