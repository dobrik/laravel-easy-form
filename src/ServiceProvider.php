<?php

namespace Dobrik\LaravelEasyForm;

use Dobrik\LaravelEasyForm\Forms\Creator;
use Dobrik\LaravelEasyForm\Forms\Factory;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom($this->getAliasesConfigPath(), 'easy_form/aliases');
        $this->mergeConfigFrom($this->getFormsConfigPath(), 'easy_form/forms');

        $this->app->singleton(Creator::class, function () {
            $creator = new Creator(new Factory());
            return $creator->setRequest($this->app->make(\Illuminate\Http\Request::class))
                ->registerFormConfig($this->app->make('config')->get('easy_form.forms'));
        }
        );
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'easy_form');

        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/easy_form'),
        ]);

        $this->publishes([
            $this->getAliasesConfigPath() => config_path('easy_form/aliases.php'),
            $this->getFormsConfigPath() => config_path('easy_form/forms.php')
        ]);
    }

    private function getAliasesConfigPath()
    {
        return __DIR__ . '/resources/config/aliases.php';
    }

    private function getFormsConfigPath()
    {
        return __DIR__ . '/resources/config/forms.php';
    }
}