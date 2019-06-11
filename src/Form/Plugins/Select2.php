<?php

namespace Dobrik\LaravelEasyForm\Forms\Plugins;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Forms\Interfaces\PluginInterface;

/**
 * Class Select2
 * @package Dobrik\LaravelEasyForm\Forms\Plugins
 */
class Select2 extends HtmlAbstract implements PluginInterface
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
        $parent->setClass($parent->getClass() . ' form-control select2');
        $parent->setMultiple('multiple');
        $parent->setName($parent->getName() . '[]');

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
