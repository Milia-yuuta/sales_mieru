<?php

namespace App\Http\ViewComposers;

use Auth;
use App\Models\ProspectActionLog;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
/**
 * Class LayoutComposer
 * @package App\Http\ViewComposers\User\Worker
 */
class ProspectActionLogInstanceComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with([
            'ProspectActionLogInstance' => new ProspectActionLog,
        ]);
    }

}