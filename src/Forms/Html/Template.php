<?php

namespace Dobrik\LaravelEasyForm\Forms\Html;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Forms\Interfaces\HasContentInterface;

/**
 * Class Template
 * @package Dobrik\LaravelEasyForm\Forms\Html
 */
class Template extends HtmlAbstract implements HasContentInterface
{
    protected $requiredAttributes = ['name'];

    /**
     * @return array
     */
    public function getData(): array
    {
        return ['content' => $this->pullContent()];
    }

    public function setContent($content): HtmlAbstract
    {
        return parent::setContent($content);
    }
}
