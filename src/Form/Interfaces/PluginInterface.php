<?php

namespace Dobrik\LaravelEasyForm\Forms\Interfaces;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Interface PluginInterface
 * @package Dobrik\LaravelEasyForm\Forms\Interfaces
 */
interface PluginInterface
{
    /**
     * @param HtmlAbstract $parent
     * @return PluginInterface
     */
    public function setParent(HtmlAbstract $parent): PluginInterface;

    /**
     * @return HtmlAbstract
     */
    public function getParent(): HtmlAbstract;
}
