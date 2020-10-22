<?php

namespace Dobrik\LaravelEasyForm\Forms\Html;

use Dobrik\LaravelEasyForm\Forms\Interfaces\HasContentInterface;
use Dobrik\LaravelEasyForm\Forms\Traits\HasContentTrait;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Div
 * @package Dobrik\LaravelEasyForm\Forms\Html
 */
class CustomHtml extends HtmlAbstract implements HasContentInterface
{
    use HasContentTrait;

    public $attributes = ['content' => ''];

    /**
     * @var array
     */
    protected $requiredAttributes = [
        'content', 'type'
    ];

    /**
     * @return array
     */
    public function getData(): array
    {
        return ['content' => $this->pullContent(), 'type' => $this->pullType()];
    }
}
