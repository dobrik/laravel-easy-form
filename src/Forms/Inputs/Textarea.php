<?php

namespace Dobrik\LaravelEasyForm\Forms\Inputs;

use Illuminate\Support\Arr;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Textarea
 * @package Dobrik\LaravelEasyForm\Forms\Inputs
 */
class Textarea extends HtmlAbstract
{

    /**
     * @var array
     */
    public $attributes = ['class' => 'form-control'];

    /**
     * @var array
     */
    protected $required_attributes = [
        'name'
    ];

    /**
     * @return array
     */
    public function getData(): array
    {
        return ['value' => Arr::pull($this->attributes, 'value')];
    }
}
