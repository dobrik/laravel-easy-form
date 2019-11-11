<?php

namespace Dobrik\LaravelEasyForm\Forms\Plugins;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Forms\Interfaces\PluginInterface;

/**
 * Class Datetimepicker
 * @package Dobrik\LaravelEasyForm\Forms\Plugins
 */
class DateTimePicker extends HtmlAbstract implements PluginInterface
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
     * @param HtmlAbstract $parent
     * @return PluginInterface
     */
    public function setParent(HtmlAbstract $parent): PluginInterface
    {
        $this->parent = $parent;
        $parent->setClass($parent->getClass() . ' datetimepicker');
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
