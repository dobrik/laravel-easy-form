<?php

namespace Dobrik\LaravelEasyForm\Forms\Html;


use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Forms\Interfaces\HasValueInterface;

/**
 * Class Input
 * @package Dobrik\LaravelEasyForm\Forms\Inputs
 */
class Checkbox extends HtmlAbstract implements HasValueInterface
{
    /**
     * @var array
     */
    protected $requiredAttributes = [
        'name'
    ];

    public function setValue($value): HtmlAbstract
    {
        if ($value) {
            $this->setChecked('checked');
        } else {
            $this->unsetChecked();
        }
        $this->attributes['value'] = '1';

        return $this;
    }

    public function getValue()
    {
        return $this->getChecked() ? '1' : null;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [];
    }
}
