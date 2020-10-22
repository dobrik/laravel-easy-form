<?php

namespace Dobrik\LaravelEasyForm\Forms;

use Dobrik\LaravelEasyForm\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

/**
 * Class HtmlAbstract
 * @package Dobrik\LaravelEasyForm\Forms
 */
abstract class HtmlAbstract
{
    /** @var array */
    public $attributes = [];

    /** @var HtmlAbstract|null */
    public $parent;

    /** @var null|string */
    protected $view;

    /** @var array */
    protected $appended = [];

    /** @var array */
    protected $requiredAttributes = [];

    /** @return array */
    abstract public function getData(): array;

    /**
     *
     * Magic method to set class attributes.
     *
     * @param string $method
     * @param mixed $arguments
     * @return $this|bool|mixed|null
     */
    public function __call(string $method, $arguments)
    {
        if (Str::startsWith($method, 'set')) {
            $attribute = Str::snake(Str::after($method, 'set'), '_');
            $this->attributes[$attribute] = Arr::first($arguments, null, null);
            return $this;
        }
        if (Str::startsWith($method, 'get')) {
            $attribute = Str::snake(Str::after($method, 'get'), '_');
            if (Arr::has($this->attributes, $attribute)) {
                return $this->attributes[$attribute];
            }
        }
        if (Str::startsWith($method, 'unset')) {
            $attribute = Str::snake(Str::after($method, 'unset'), '_');
            if (Arr::has($this->attributes, $attribute)) {
                unset($this->attributes[$attribute]);
            }
            return $this;
        }
        if (Str::startsWith($method, 'pull')) {
            $attribute = Str::snake(Str::after($method, 'pull'), '_');
            if (Arr::has($this->attributes, $attribute)) {
                return Arr::pull($this->attributes , $attribute);
            }
        }
        return null;
    }

    /**
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function checkRequiredData(): void
    {
        foreach ($this->requiredAttributes as $requiredAttribute) {
            if (!array_key_exists($requiredAttribute, $this->attributes)) {
                throw new \InvalidArgumentException(sprintf('Attribute "%s" is required for this field type. File: "%s" Line: "%d"', $requiredAttribute, __FILE__, __LINE__));
            }
        }
    }

    /**
     * @return string
     * @throws \ReflectionException
     * @throws \Throwable
     */
    final protected function compile(): string
    {
        $this->checkRequiredData();

        return $this->getView($this->getData());
    }

    /**
     * @param array $data
     * @return string
     * @throws \RuntimeException
     */
    protected function getView($data = []): string
    {
        if ($this->view !== null) {
            return $this->view;
        }
        if (view()->exists($template = $this->getTemplatePath())) {
            $appendContent = '';
            foreach ($this->appended as $item) {
                $appendContent .= PHP_EOL . $item;
            }

            return $this->view = view(
                    $template,
                    array_merge(['attributes' => $this->attributes, 'object' => $this, 'appended' => $this->appended], $data)
                )->render() . $appendContent;
        }

        throw new \RuntimeException(sprintf('Template: "%s" not found.', $template));
    }

    protected function getTemplatePath(): string
    {
        $class_name = get_class($this);
        $class_name_array = explode('\\', $class_name);
        $class_name_array = \array_slice($class_name_array, -2);
        $template = 'easy_form::';
        foreach ($class_name_array as $key => $item) {
            $template .= $key === 0 ? '' : '.';
            $template .= strtolower(Str::snake($item, '_'));
        }

        return $template;
    }

    /**
     * @param string|array $data
     * @return HtmlAbstract
     */
    public function append($data): HtmlAbstract
    {
        if (\is_array($data)) {
            $this->appended = array_merge($this->appended, $data);
        } else {
            $this->appended[] = $data;
        }

        return $this;
    }

    /**
     * @return array Input attributes array.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     * @return HtmlAbstract
     */
    public function setAttributes(array $attributes): HtmlAbstract
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function mergeAttributes(array $attributes): HtmlAbstract
    {
        $this->attributes = array_merge($this->attributes, $attributes);
        return $this;
    }

    /**
     * @return string.
     * @throws \ReflectionException
     * @throws \Throwable
     */
    public function __toString()
    {
        if ($this->view === null) {
            $this->compile();
        }
        return (string)$this->view;
    }

    /**
     * @param HtmlAbstract $parent
     * @return HtmlAbstract
     */
    public function setParent(HtmlAbstract $parent): HtmlAbstract
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return HtmlAbstract|null
     */
    public function getParent(): ?HtmlAbstract
    {
        return $this->parent;
    }
}
