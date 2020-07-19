<?php

namespace Dobrik\LaravelEasyForm\Forms\Plugin;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Select2
 * @package Dobrik\LaravelEasyForm\Forms\Plugins
 */
class ColorPicker extends HtmlAbstract
{

    /**
     * @var array
     */
    protected $requiredAttributes = [
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
     * @return HtmlAbstract
     */
    public function setParent(HtmlAbstract $parent): HtmlAbstract
    {
        $parent->setType('color');
        $parent->setStyle('height: 50px;');

        $this->parent = $parent;
        return $this;
    }
}
