<?php

namespace Dobrik\LaravelEasyForm\Forms\Interfaces;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

interface HasValueInterface
{
    public function setValue($value): HtmlAbstract;
}