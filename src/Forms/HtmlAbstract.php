<?php

namespace Dobrik\LaravelEasyForm\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

/**
 * Class HtmlAbstract
 * @package Dobrik\LaravelEasyForm\Forms
 */
abstract class HtmlAbstract
{
    /**
     * @var array
     */
    public $attributes = [];

    /**
     * @var View
     */
    protected $view;

    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var array
     */
    protected $appended = [];

    /**
     * @var array
     */
    protected $required_attributes = [];

    /**
     * @return array
     */
    abstract public function getData(): array;

    /**
     * HtmlAbstract constructor.
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
        $this->attributes['id'] = Str::random(10);
    }

    /**
     *
     * Magic method to set class attributes.
     *
     * @param string $method
     * @param mixed $attributes
     * @return $this|bool|mixed|null
     */
    public function __call(string $method, $attributes)
    {
        if (Str::startsWith($method, 'set')) {
            $method = Str::snake($method, '_');
            $attribute = strtolower(str_replace('set_', '', $method));
            $value = Arr::first($attributes, null, null);
            $this->attributes[$attribute] = $value;
            return $this;
        }
        if (Str::startsWith($method, 'get')) {
            $method = Str::snake($method, '_');
            $attribute = strtolower(str_replace('get_', '', $method));
            if (Arr::has($this->attributes, Str::snake($attribute, '_'))) {
                return $this->attributes[$attribute];
            }
            return null;
        }
        if (Str::startsWith($method, 'unset')) {
            $method = Str::snake($method, '_');
            $attribute = strtolower(str_replace('unset_', '', $method));
            if (Arr::has($this->attributes, Str::snake($attribute, '_'))) {
                unset($this->attributes[$attribute]);
            }
            return $this;
        }
        return false;
    }

    /**
     * @throws \InvalidArgumentException
     * @return void
     */
    protected function checkRequiredData(): void
    {
        foreach ($this->required_attributes as $required_attribute) {
            if (!array_key_exists($required_attribute, $this->attributes)) {
                throw new \InvalidArgumentException(sprintf('Attribute "%s" is required for this field type. File: "%s" Line: "%d"', $required_attribute, __FILE__, __LINE__));
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
        $class_name = get_class($this);
        $class_name_array = explode('\\', $class_name);
        $class_name_array = \array_slice($class_name_array, -2);
        $template = 'creator';
        foreach ($class_name_array as $item) {
            $template .= '.' . strtolower(Str::snake($item, '_'));
        }

        if (view()->exists($template)) {
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

    /**
     * @param string|array $data
     * @return HtmlAbstract
     */
    public function append($data): HtmlAbstract
    {
        if (\is_array($data)) {
            $this->appended = array_merge($this->appended, $data);
        } else {
            if ($data instanceof self) {
                $data->setDataId($this->attributes['id']);
            }
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
     * @return Factory
     */
    public function getFactory(): Factory
    {
        return $this->factory;
    }

    /**
     * @return string.
     * @throws \ReflectionException
     * @throws \Throwable
     */
    public function __toString()
    {
        if ($this->view === null) {
            $this->nameToArrayDot();
            $this->compile();
        }
        return (string)$this->view;
    }
}
