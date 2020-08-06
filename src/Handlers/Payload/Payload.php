<?php


namespace Dobrik\LaravelEasyForm\Handlers\Payload;

use Dobrik\LaravelEasyForm\Builder;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Illuminate\Contracts\Container\Container;

class Payload
{
    /** @var Container */
    private $container;

    /** @var HtmlAbstract */
    private $htmlAbstract;

    /** @var Builder */
    private $builder;

    /**  @var array */
    private $elementConfig;

    /** @var array */
    private $data;

    public function __construct(Container $container, HtmlAbstract $htmlAbstract, Builder $builder, array $elementConfig = [], array $data = [])
    {
        $this->container = $container;
        $this->htmlAbstract = $htmlAbstract;
        $this->builder = $builder;
        $this->elementConfig = $elementConfig;
        $this->data = $data;
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @return HtmlAbstract
     */
    public function getHtmlAbstract(): HtmlAbstract
    {
        return $this->htmlAbstract;
    }

    /**
     * @return Builder
     */
    public function getBuilder(): Builder
    {
        return $this->builder;
    }

    /**
     * @return array
     */
    public function getElementConfig(): array
    {
        return $this->elementConfig;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param HtmlAbstract $htmlAbstract
     * @return Payload
     */
    public function setHtmlAbstract(HtmlAbstract $htmlAbstract): Payload
    {
        $this->htmlAbstract = $htmlAbstract;
        return $this;
    }

    /**
     * @param array $elementConfig
     * @return Payload
     */
    public function setElementConfig(array $elementConfig): Payload
    {
        $this->elementConfig = $elementConfig;
        return $this;
    }

    /**
     * @param array $data
     * @return Payload
     */
    public function setData(array $data): Payload
    {
        $this->data = $data;
        return $this;
    }
}