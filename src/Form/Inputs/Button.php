<?php

namespace Dobrik\LaravelEasyForm\Forms\Inputs;

use Illuminate\Support\Arr;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Button
 * @package Dobrik\LaravelEasyForm\Forms\Inputs
 */
class Button extends HtmlAbstract
{
    /**
     * @var array
     */
    protected $required_attributes = [
        'title'
    ];

    /**
     * @return array
     */
    public function getData(): array
    {
        return ['title' => Arr::pull($this->attributes, 'title')];
    }
}
