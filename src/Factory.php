<?php

namespace Dobrik\LaravelEasyForm;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Exceptions\InvalidAliasException;

/**
 * Class Factory
 * @package Dobrik\LaravelEasyForm\Forms Factory create HtmlAbstract instances.
 * @method HtmlAbstract html(string $name)
 * @method HtmlAbstract plugin(string $name)
 * @method HtmlAbstract filter(string $name)
 */
class Factory
{
    private $aliases = [
        'plugin' => [

        ],
        'html' => [

        ],
    ];

    public function mergeAliases(array $aliases)
    {
        $this->aliases = array_merge_recursive($this->aliases, $aliases);
        return $this;
    }

    /**
     * @param string $alias Name of input|html|plugin class.
     * @param string $type Part of namespace inputs|html|plugins.
     */
    public function make(string $alias, string $type)
    {
        if (!array_key_exists(strtolower($alias), $this->aliases[$type])) {
            throw new InvalidAliasException(sprintf('Alias "%s" for type "%s" not registered', $alias, $type));
        }

        $class = $this->aliases[$type][strtolower($alias)];
        return new $class($this);
    }

    public function __call($name, $arguments)
    {
        if (array_key_exists($name, $this->aliases)) {
            return $this->make($arguments[0], $name);
        }
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
