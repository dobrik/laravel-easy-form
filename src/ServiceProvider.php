<?php

namespace Dobrik\LaravelEasyForm;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom($this->getAliasesConfigPath(), 'easy_form.aliases');
        $this->mergeConfigFrom($this->getFormsConfigPath(), 'easy_form.forms');
        $this->mergeConfigFrom($this->getMainConfigPath(), 'easy_form.config');

        $this->app->singleton(Factory::class, function () {
            $factory = new Factory();
            return $factory->mergeAliases($this->app->make('config')->get('easy_form.aliases'));
        });

        $this->app->singleton(Creator::class, function () {
            $creator = new Creator($this->app->make(Factory::class), $this->app->make('config'));
            return $creator->setRequest($this->app->make(\Illuminate\Http\Request::class));
        }
        );
    }

    public function boot()
    {
        $this->loadViewsFrom($this->getViewsPath(), 'easy_form');


        $this->publishes([
            $this->getAliasesConfigPath() => config_path('easy_form/aliases.php'),
            $this->getMainConfigPath() => config_path('easy_form/config.php'),
            $this->getFormsConfigPath() => config_path('easy_form/forms.php'),
            $this->getViewsPath() => resource_path('views/vendor/easy_form'),
        ]);
        $this->publishes([__DIR__ . '/resources/assets' => public_path('vendor/easy_form/assets')], 'assets');
    }

    private function getMainConfigPath()
    {
        return __DIR__ . '/resources/config/config.php';
    }

    private function getAliasesConfigPath()
    {
        return __DIR__ . '/resources/config/aliases.php';
    }

    private function getFormsConfigPath()
    {
        return __DIR__ . '/resources/config/forms.php';
    }

    private function getViewsPath(): string
    {
        return __DIR__ . '/resources/views';
    }
}