<?php

namespace Dobrik\LaravelEasyForm\Forms\Html;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Forms\Interfaces\HasValueInterface;

/**
 * Class Image
 * @package Dobrik\LaravelEasyForm\Forms\Inputs
 */
class Image extends HtmlAbstract implements HasValueInterface
{

    /**
     * @var array
     */
    protected $requiredAttributes = [
        'name', 'title'
    ];

    /**
     * @return array
     */
    public function getData(): array
    {
        return [];
    }

    public function setValue($value): HtmlAbstract
    {
        $this->attributes['value'] = $value;
        return  $this;
    }
}
