<?php

namespace Services\Mbarlow;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Console\Commands\ClearOldNotifications;
use Services\Mbarlow\Livewire\Megaphone;
use Services\Mbarlow\Livewire\Popout;

class MegaphoneServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearOldNotifications::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'megaphone');

        Blade::componentNamespace('Services\\Mbarlow\\Components', 'megaphone');

        Livewire::component(
            'megaphone',
            Megaphone::class
        );
        Livewire::component(
            'megaphone.popout',
            Popout::class
        );
        

    }
}
