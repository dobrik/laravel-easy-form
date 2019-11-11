<?php

namespace Dobrik\LaravelEasyForm;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Exceptions\InvalidAliasException;
use Dobrik\LaravelEasyForm\Forms\Interfaces\PluginInterface;

/**
 * Class Factory
 * @package Dobrik\LaravelEasyForm\Forms Factory create HtmlAbstract instances.
 */
class Factory
{
    private $aliases = [
        'plugins' => [
            'ckeditor' => Forms\Plugins\Ckeditor::class,
            'color_picker' => Forms\Plugins\ColorPicker::class,
            'air_date_picker' => Forms\Plugins\AirDatePicker::class,
            'datetimepicker' => Forms\Plugins\DateTimePicker::class,
            'select2' => Forms\Plugins\Select2::class,
        ],
        'html' => [
            'div' => Forms\Html\Div::class,
            'tab' => Forms\Html\Tab::class,
            'tabs' => Forms\Html\Tabs::class,
        ],
        'inputs' => [
            'button' => Forms\Inputs\Button::class,
            'form' => Forms\Inputs\Form::class,
            'image' => Forms\Inputs\Image::class,
            'input' => Forms\Inputs\Input::class,
            'select' => Forms\Inputs\Select::class,
            'textarea' => Forms\Inputs\Textarea::class,
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
