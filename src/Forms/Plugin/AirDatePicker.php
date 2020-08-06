<?php

namespace Dobrik\LaravelEasyForm\Forms\Plugin;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class AirDatePicker
 * @package Dobrik\LaravelEasyForm\Forms\Plugins
 */
class AirDatePicker extends HtmlAbstract
{


    /**
     * @return array
     */
    public function getData(): array
    {
        return [];
    }

    /**
     *
     * Plugin has no body
     *
     * @param array $data
     * @return string
     */
    protected function getView($data = []): string
    {
        return '';
    }

    /**
     * @param HtmlAbstract $parent
     * @return HtmlAbstract
     */
    public function setParent(HtmlAbstract $parent): HtmlAbstract
    {
        $parent->setClass($parent->getClass() . ' datepicker-here');

        $this->parent = $parent;
        return $this;
    }
}
