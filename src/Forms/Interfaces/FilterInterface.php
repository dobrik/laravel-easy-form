<?php

namespace Dobrik\LaravelEasyForm\Forms\Interfaces;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

interface FilterInterface
{
    public function apply(HtmlAbstract $htmlAbstract, array $data = [], array $parameters = []): void;
}
