<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperSeviceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(app_path().'/Utils/Helpers/*.php') as $fileName){
            require_once($fileName);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
