<?php

namespace Dobrik\LaravelEasyForm\Forms\Html;

use Dobrik\LaravelEasyForm\Forms\Interfaces\HasContentInterface;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Forms\Traits\HasContentTrait;
use Illuminate\Support\Arr;

/**
 * Class Tab
 * @package Dobrik\LaravelEasyForm\Forms\Html
 */
class Tab extends HtmlAbstract implements HasContentInterface
{
    use HasContentTrait;
    /**
     * @var array
     */
    protected $requiredAttributes = [
        'title', 'id'
    ];

    /**
     * @return array
     * @throws \Throwable
     */
    public function getData(): array
    {
        return ['content' => $this->pullContent()];
    }
}
