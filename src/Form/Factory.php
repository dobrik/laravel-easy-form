<?php

namespace Dobrik\LaravelEasyForm\Forms;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Dobrik\LaravelEasyForm\Forms\Interfaces\PluginInterface;

/**
 * Class Factory
 * @package Dobrik\LaravelEasyForm\Forms Factory create HtmlAbstract instances.
 */
class Factory
{
    /**
     * @param string $class Name of input|html|plugin class.
     * @param string $type Part of namespace inputs|html|plugins.
     */
    public function make(string $class, string $type)
    {
        $class = ucfirst(camel_case(trim($class)));
        $class = "Dobrik\\LaravelEasyForm\\Forms\\$type\\$class";
        return new $class($this);
    }

    /**
     * @param string $class Alias for make($class, 'Plugins') call.
     * @return PluginInterface
     */
    public function plugin(string $class): PluginInterface
    {
        return $this->make($class, 'plugins');
    }

    /**
     * @param string $class Alias for make($class, 'Inputs') call.
     * @return HtmlAbstract
     */
    public function input(string $class): HtmlAbstract
    {
        return $this->make($class, 'inputs');
    }

    /**
     * @param string $class Alias for make($class, 'Html') call.
     * @return HtmlAbstract
     */
    public function html(string $class): HtmlAbstract
    {
        return $this->make($class, 'html');
    }

    /**
     * @param string $name
     * @param string $field_data
     * @param null $label
     * @return HtmlAbstract|boolean|null
     */
    public function autoMake(string $name, string $field_data, $label = null)
    {
        $data = explode(':', $field_data);
        $field = null;

        if (\count($data) > 0 && !empty($data[0])) {
            $field = $this->input(ucfirst($data[0]));
            $field->setName($name);
            if ($label != null) {
                $field->setLabel($label);
            }
            if (\count($data) > 1) {
                if (!empty($data[1])) {
                    $field->setType($data[1]);
                }
                if (\count($data) > 2 && !empty($data[2])) {
                    $field->setValues($data[2]);

                }
            }
        }

        if ($field !== null) {
            return $field;
        }
        return false;
    }
}
