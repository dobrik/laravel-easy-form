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
    public $attributes = ['class' => 'form-control', 'action' => '?', 'method' => 'post', 'ajax' => false];

    /**
     * @var array
     */
    protected $required_attributes = [
        'content'
    ];

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
     * @return array
     */
    public function getData(): array
    {
        return [
            'form' => $this->getContent(),
            'buttons' => $this->getButtons(),
            'method' => $this->getMethod(),
            'action' => $this->getAction()
        ];
    }
}
