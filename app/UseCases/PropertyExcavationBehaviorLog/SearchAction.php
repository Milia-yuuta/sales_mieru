<?php


namespace App\UseCases\PropertyExcavationBehaviorLog;


use Illuminate\Support\Facades\Auth;
use App\Models\PropertyExcavationBehaviorLog;

class SearchAction
{
    public function __invoke(): array
    {
        $userId = Auth::user()->id;
        return PropertyExcavationBehaviorLog::with('property')->where('user_id', $userId)->get()->toArray();
    }
}