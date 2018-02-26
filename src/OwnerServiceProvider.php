<?php

namespace Wcr\Owner;

use Illuminate\Support\ServiceProvider;
use Event;

class OwnerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes([__DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'], 'migrations');

        Event::listen('crud.created', 'Wcr\Owner\Events\OwnerEvents@entityCreated' );
        Event::listen('crud.updated', 'Wcr\Owner\Events\OwnerEvents@entityUpdated' );
        Event::listen('crud.deleted', 'Wcr\Owner\Events\OwnerEvents@entityDeleted' );
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
