<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeNavigation();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function composeNavigation()
    {
        view()->composer('layouts._navbar', function($view)
        {
            $view->with('current_user', Auth::user()); 
        });
    }
}
