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
    public $attributes = ['values' => []];
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
        if ($this->getValue() instanceof Collection) {
            $this->setMultiple('multiple');
            $this->setName($this->getName() . '[]');
        }

        return ['values' => $this->pullValues()];
    }
}
