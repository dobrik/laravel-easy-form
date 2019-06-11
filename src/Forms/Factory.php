<?php

namespace Dobrik\LaravelEasyForm\Forms;

use Dobrik\LaravelEasyForm\Exceptions\InvalidAliasException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Dobrik\LaravelEasyForm\Forms\Interfaces\PluginInterface;

/**
 * Class Factory
 * @package Dobrik\LaravelEasyForm\Forms Factory create HtmlAbstract instances.
 */
class Factory
{
    private $aliases = [
        'plugins' => [
            'ckeditor' => Plugins\Ckeditor::class,
            'color_picker' => Plugins\ColorPicker::class,
            'datetimepicker' => Plugins\Datetimepicker::class,
            'select2' => Plugins\Select2::class,
        ],
        'html' => [
            'div' => Html\Div::class,
            'tab' => Html\Tab::class,
            'tabs' => Html\Tabs::class,
        ],
        'inputs' => [
            'button' => Inputs\Button::class,
            'form' => Inputs\Form::class,
            'image' => Inputs\Image::class,
            'input' => Inputs\Input::class,
            'select' => Inputs\Select::class,
            'textarea' => Inputs\Textarea::class,
        ],
    ];

    public function __construct(array $aliases = [])
    {
        $this->aliases = array_merge($this->aliases, $aliases);
    }

    /**
     * @param string $alias Name of input|html|plugin class.
     * @param string $type Part of namespace inputs|html|plugins.
     */
    public function make(string $alias, string $type)
    {
        if (!array_key_exists($alias, $this->aliases[$type])) {
            throw new InvalidAliasException(sprintf('Alias "%s" for type "%s" not registered', $alias, $type));
        }

        $class = $this->aliases[$type][$alias];
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
