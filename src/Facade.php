<?php

namespace Dobrik\LaravelEasyForm;

class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return Builder::class;
    }
}