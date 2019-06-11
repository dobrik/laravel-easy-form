<?php

namespace Dobrik\LaravelEasyForm\Forms\Inputs;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Form
 * @package Dobrik\LaravelEasyForm\Forms\Inputs
 */
class Form extends HtmlAbstract
{
    /**
     * @var array
     */
    public $attributes = ['class' => 'form-control', 'action' => '?', 'method' => 'post'];

    /**
     * @var array
     */
    protected $required_attributes = [
        'content'
    ];

    /**
     * @var boolean
     */
    private $isAjax = false;

    /**
     * @param HtmlAbstract $button
     * @return $this
     */
    public function addButton(HtmlAbstract $button)
    {
        if ($this->getButtons() === null) {
            $this->setButtons((string)$button);
        } else {
            $this->attributes['buttons'] .= $button;
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function ajax()
    {
        $this->isAjax = true;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'form' => $this->getContent(),
            'buttons' => $this->getButtons(),
            'method' => $this->getMethod(),
            'action' => $this->getAction(),
            'ajax' => $this->isAjax,
        ];
    }
}
