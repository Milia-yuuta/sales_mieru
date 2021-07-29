<?php

namespace App\Http\ViewComposers;

use Auth;
use App\Models\UserMaster;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
/**
 * Class LayoutComposer
 * @package App\Http\ViewComposers\User\Worker
 */
class UserMasterInstanceComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with([
            'UserMaster' => new UserMaster,
        ]);
    }

}