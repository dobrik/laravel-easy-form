<?php

namespace Dobrik\LaravelEasyForm\Forms\Inputs;


use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Input
 * @package Dobrik\LaravelEasyForm\Forms\Inputs
 */
class Input extends HtmlAbstract
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

    public function setValue($value)
    {
        if ($this->getType() === 'checkbox') {
            if ($value == 1) {
                $this->setChecked('checked');
            } else {
                $this->unsetChecked();
            }
            return $this;
        }

        return parent::setValue($value);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        if ($this->getType() == 'checkbox') {
            $this->setClass('');
            $this->setValue('1');
        }

        return [];
    }
}
