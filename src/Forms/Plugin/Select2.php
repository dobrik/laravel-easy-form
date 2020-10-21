<?php

namespace Dobrik\LaravelEasyForm\Forms\Plugin;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Select2
 * @package Dobrik\LaravelEasyForm\Forms\Plugins
 */
class Select2 extends HtmlAbstract
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
        $parent->setClass($parent->getClass() . ' form-control select2');

        $this->parent = $parent;
        return $this;
    }
}
