<?php

namespace App\Http\ViewComposers;

use Auth;
use App\Models\Property;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
/**
 * Class LayoutComposer
 * @package App\Http\ViewComposers\User\Worker
 */
class PropertyArrayComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with([
            'PropertyInstance' => new Property,
        ]);
    }

}