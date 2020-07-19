<?php

namespace Dobrik\LaravelEasyForm\Forms\Html;

use Dobrik\LaravelEasyForm\Forms\Interfaces\HasValueInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Select
 * @package App\Helpers\Creator
 */
class Select extends HtmlAbstract implements HasValueInterface
{
    /**
     * @var array
     */
    public $attributes = ['class' => 'form-control', 'values' => []];
    /**
     * @var array
     */
    protected $requiredAttributes = [
        'name'
    ];

    /**
     * @param mixed $value
     * @return HtmlAbstract
     */
    public function setValue($value): HtmlAbstract
    {
        if (\is_array($value)) {
            $value = new Collection($value);
        }

        return parent::setValue($value);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return ['values' => Arr::pull($this->attributes, 'values')];
    }
}
