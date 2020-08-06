<?php

namespace Dobrik\LaravelEasyForm\Forms\Plugin;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Datetimepicker
 * @package Dobrik\LaravelEasyForm\Forms\Plugins
 */
class DateTimePicker extends HtmlAbstract
{

    /**
     * @return array
     */
    public function getData(): array
    {
        return [];
    }

    /**
     * @param HtmlAbstract $parent
     * @return HtmlAbstract
     */
    public function setParent(HtmlAbstract $parent): HtmlAbstract
    {
        $this->parent = $parent;
        $parent->setClass($parent->getClass() . ' datetimepicker');
        return $this;
    }
}
