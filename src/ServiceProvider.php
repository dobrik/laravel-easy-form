<?php

namespace Dobrik\LaravelEasyForm;

use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom($this->getAliasesConfigPath(), 'easy_form.aliases');
        $this->mergeConfigFrom($this->getFormsConfigPath(), 'easy_form.forms');
        $this->mergeConfigFrom($this->getMainConfigPath(), 'easy_form.config');
        $this->mergeConfigFrom($this->getHandlersConfigPath(), 'easy_form.handlers');
        $this->mergeConfigFrom($this->getDefaultsConfigPath(), 'easy_form.defaults');
        $this->mergeConfigFrom($this->getTemplatesConfigPath(), 'easy_form.templates');

        $this->app->singleton(Factory::class, function () {
            $factory = new Factory($this->app);
            return $factory->mergeAliases($this->app->make('config')->get('easy_form.aliases'));
        });

        $this->app->singleton(Builder::class, function () {
            return new Builder(
                $this->app->make(Container::class),
                $this->app->make(Factory::class),
                $this->app->make('config')
            );
        }
        );
    }

    public function boot()
    {
        $this->loadViewsFrom($this->getViewsPath(), 'easy_form');

        $this->publishes([
            $this->getAliasesConfigPath() => config_path('easy_form/aliases.php'),
            $this->getFormsConfigPath() => config_path('easy_form/forms.php'),
            $this->getMainConfigPath() => config_path('easy_form/config.php'),
            $this->getHandlersConfigPath() => config_path('easy_form/handlers.php'),
            $this->getDefaultsConfigPath() => config_path('easy_form/defaults.php'),
            $this->getTemplatesConfigPath() => config_path('easy_form/templates.php'),
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

    private function getHandlersConfigPath()
    {
        return __DIR__ . '/resources/config/handlers.php';
    }

    private function getDefaultsConfigPath()
    {
        return __DIR__ . '/resources/config/defaults.php';
    }

    private function getTemplatesConfigPath()
    {
        return __DIR__ . '/resources/config/templates.php';
    }

    private function getViewsPath(): string
    {
        return __DIR__ . '/resources/views';
    }

}
