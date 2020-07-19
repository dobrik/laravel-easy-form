<?php

namespace Dobrik\LaravelEasyForm\Forms\Html;

use Dobrik\LaravelEasyForm\Forms\Interfaces\HasValueInterface;
use Illuminate\Support\Arr;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Textarea
 * @package Dobrik\LaravelEasyForm\Forms\Inputs
 */
class Textarea extends HtmlAbstract implements HasValueInterface
{

    /**
     * @var array
     */
    public $attributes = ['class' => 'form-control'];

    /**
     * @var array
     */
    protected $requiredAttributes = [
        'name'
    ];

    /**
     * @return array
     */
    public function getData(): array
    {
        return ['value' => Arr::pull($this->attributes, 'value')];
    }

    public function setValue($value): HtmlAbstract
    {
        $this->attributes['value'] = $value;
        return  $this;
    }
}
