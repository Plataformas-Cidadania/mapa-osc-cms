<?php

namespace Cms\Providers;

use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        if(!$this->app->routesAreCached()){
            require __DIR__."/../routes.php";
        }

        $this->loadViewsFrom(__DIR__."/../../resources/views", "cms");

        $this->publishes([
            __DIR__."/../../database/migrations" => database_path("migrations")
        ], 'migrations');

        $this->publishes([
            __DIR__."/../../public" => public_path()
        ]);

        $router->middleware('authcms', '\Cms\Middleware\Authenticate');
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
