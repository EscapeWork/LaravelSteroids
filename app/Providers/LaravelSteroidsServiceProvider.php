<?php namespace EscapeWork\LaravelSteroids\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelSteroidsServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Illuminate\Contracts\Bus\Dispatcher',
            'EscapeWork\LaravelSteroids\Dispatcher'
        );
    }

}
