<?php

namespace App\Http\ViewComposers;

use App\Models\UserMaster;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\PrefectureMaster;

/**
 * Class LayoutComposer
 * @package App\Http\ViewComposers\User\Worker
 */
class OfficeMasterArrayComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $user = new UserMaster;
        $view->with(array(
            'OfficeList' => $user->OfficeList,
        ));
    }

}