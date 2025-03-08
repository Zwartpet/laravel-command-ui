<?php

namespace Zwartpet\CommandUI;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Zwartpet\CommandUI\Livewire\CommandUIComponent;

class CommandUIServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'command-ui');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'command-ui');
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        Livewire::component('command-ui-component', CommandUIComponent::class);

        if ($this->app->runningInConsole()) {
            //            $this->optimizes(
            //                optimize: 'schedule:optimize',
            //            );

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('command-ui.php'),
            ], ['config', 'command-ui', 'command-ui-config']);

            $this->publishes([
                __DIR__.'/../public/vendor/command-ui/assets' => public_path('vendor/command-ui/assets'),
                __DIR__.'/../public/vendor/command-ui/manifest.json' => public_path('vendor/command-ui/manifest.json'),
            ], ['assets', 'command-ui', 'command-ui-assets']);

            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/command-ui'),
            ], ['lang', 'command-ui', 'command-ui-lang']);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'command-ui');
    }
}
