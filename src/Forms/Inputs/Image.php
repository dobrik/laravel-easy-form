<?php

namespace Dobrik\LaravelEasyForm\Forms\Inputs;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Image
 * @package Dobrik\LaravelEasyForm\Forms\Inputs
 */
class Image extends HtmlAbstract
{

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
        return [];
    }
}
