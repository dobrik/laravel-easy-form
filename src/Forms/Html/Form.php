<?php

namespace Dobrik\LaravelEasyForm\Forms\Html;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Forms\Interfaces\HasContentInterface;
use Dobrik\LaravelEasyForm\Forms\Traits\HasContentTrait;

/**
 * Class Form
 * @package Dobrik\LaravelEasyForm\Forms\Inputs
 */
class Form extends HtmlAbstract implements HasContentInterface
{
    use HasContentTrait;
    /**
     * @var array
     */
    public $attributes = ['action' => '?', 'method' => 'post', 'enctype' => 'multipart/form-data'];

    /**
     * @var array
     */
    protected $requiredAttributes = [
        'content'
    ];

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'form' => $this->pullContent(),
            'method' => $this->pullMethod(),
            'action' => $this->pullAction()
        ];
    }
}
