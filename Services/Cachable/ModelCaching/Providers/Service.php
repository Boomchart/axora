<?php

namespace Services\Cachable\ModelCaching\Providers;

use Services\Cachable\ModelCaching\Console\Commands\Clear;
use Services\Cachable\ModelCaching\Console\Commands\Publish;
use Services\Cachable\ModelCaching\Helper;
use Services\Cachable\ModelCaching\ModelCaching;
use Illuminate\Support\ServiceProvider;

class Service extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $configPath = __DIR__ . '/../../config/laravel-model-caching.php';
        $this->mergeConfigFrom($configPath, 'laravel-model-caching');
        $this->commands([
            Clear::class,
            Publish::class,
        ]);
        $this->publishes([
            $configPath => config_path('laravel-model-caching.php'),
        ], "config");
    }

    public function register()
    {
        if (! class_exists('Services\Cachable\ModelCaching\EloquentBuilder')) {
            class_alias(
                ModelCaching::builder(),
                'Services\Cachable\ModelCaching\EloquentBuilder'
            );
        }

        $this->app->bind("model-cache", Helper::class);
    }
}
