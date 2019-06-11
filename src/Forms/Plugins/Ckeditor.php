<?php

namespace Dobrik\LaravelEasyForm\Forms\Plugins;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Forms\Interfaces\PluginInterface;

/**
 * Class Ckeditor
 * @package Dobrik\LaravelEasyForm\Forms\Plugins
 */
class Ckeditor extends HtmlAbstract implements PluginInterface
{
    /**
     * @var HtmlAbstract
     */
    protected $parent;
    /**
     * @var array
     */
    protected $required_attributes = [
        'name'
    ];

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
