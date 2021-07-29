<?php

namespace App\Http\ViewComposers;

use Auth;
use App\Models\ActionMaster;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
/**
 * Class LayoutComposer
 * @package App\Http\ViewComposers\User\Worker
 */
class ActionMasterArrayComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with([
            'ActionMasterInstance' => new ActionMaster,
        ]);
    }

}