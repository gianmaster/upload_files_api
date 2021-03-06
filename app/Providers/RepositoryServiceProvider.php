<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\ArchivoRepository::class, \App\Repositories\ArchivoRepositoryEloquent::class);
        //$this->app->bind(\App\Repositories\LogRepository::class, \App\Repositories\LogRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OauthClientRepository::class, \App\Repositories\OauthClientRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CatalogoRepository::class, \App\Repositories\CatalogoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CatalogoItemRepository::class, \App\Repositories\CatalogoItemRepositoryEloquent::class);
        //:end-bindings:
    }
}
