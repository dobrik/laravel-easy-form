<?php

namespace Dobrik\LaravelEasyForm;

class FactoryFacade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}