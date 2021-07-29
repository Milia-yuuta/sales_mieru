<?php

namespace App\Http\ViewComposers;

use Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\PrefectureMaster;

/**
 * Class LayoutComposer
 * @package App\Http\ViewComposers\User\Worker
 */
class LayoutComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with([
            'loginUser' => Auth::user(),
            'UserList' =>  User::all(),
            'PrefectureList' => new PrefectureMaster,
        ]);
    }

}