<?php

namespace Dobrik\LaravelEasyForm\Forms\Interfaces;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface FilterInterface
 * @package Dobrik\LaravelEasyForm\Forms\Interfaces
 */
interface FilterInterface
{
    public function apply(HtmlAbstract $htmlAbstract, Model $model = null): void;
}
