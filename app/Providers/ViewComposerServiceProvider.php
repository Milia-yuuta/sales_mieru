<?php

namespace App\Providers;

use App\Http\ViewComposers;
use Illuminate\Support\ServiceProvider;
use View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composers([
            ViewComposers\LayoutComposer::class => ['layouts.*', 'property.*', 'dailyReport.*', 'prospect.index', 'dailyReport.*'],
            ViewComposers\ExcavationArrayComposer::class => ['property.*', 'prospect.*', 'dailyReport.*'],
            ViewComposers\ActionMasterArrayComposer::class => ['prospect.*', 'dailyReport.*', 'property.*', 'layouts.*', 'index'],
            ViewComposers\PropertyArrayComposer::class => ['prospect.*', 'dailyReport.*'],
            ViewComposers\ProspectActionLogInstanceComposer::class => ['prospect.*', 'dailyReport.*'],
            ViewComposers\OfficeMasterArrayComposer::class => ['analysis.*'],
            ViewComposers\UserMasterInstanceComposer::class => ['prospect.*', 'property.*', 'dailyReport.*', 'analysis.*'],
        ]);
    }
}
