<?php

namespace Dobrik\LaravelEasyForm\Forms\Plugins;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Forms\Interfaces\PluginInterface;

/**
 * Class AirDatePicker
 * @package Dobrik\LaravelEasyForm\Forms\Plugins
 */
class AirDatePicker extends HtmlAbstract implements PluginInterface
{

    /**
     * @var HtmlAbstract
     */
    protected $parent;

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
     * @return PluginInterface
     */
    public function setParent(HtmlAbstract $parent): PluginInterface
    {
        $parent->setClass($parent->getClass() . ' datepicker-here');

        $this->parent = $parent;
        return $this;
    }

    /**
     * @return HtmlAbstract
     */
    public function getParent(): HtmlAbstract
    {
        return $this->parent;
    }
}
