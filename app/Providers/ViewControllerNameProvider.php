<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewControllerNameProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app('view')->composer('layouts.app', function($view)
        {
            $action = app('request')->route()->getAction();

            $controller = class_basename($action['controller']);

            list($controller, $action) = explode('@', $controller);

            $view->with(compact('controller', 'action'));
        });
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
}
