<?php

namespace Dobrik\LaravelEasyForm\Forms\Html;


use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Forms\Interfaces\HasValueInterface;

/**
 * Class Input
 * @package Dobrik\LaravelEasyForm\Forms\Inputs
 */
class Input extends HtmlAbstract implements HasValueInterface
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

    public function setValue($value): HtmlAbstract
    {
        if ($this->getType() === 'checkbox') {
            if ($value) {
                $this->setChecked('checked');
            } else {
                $this->unsetChecked();
            }
            $this->attributes['value'] = '1';
        } else {
            parent::setValue($value);
        }
        return $this;
    }

    public function getValue()
    {
        if ($this->getType() === 'checkbox') {
            return $this->getChecked() ? '1' : null;
        }
        return parent::getValue();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        if ($this->getType() == 'checkbox') {
            $this->setClass('');
        }

        return [];
    }
}
