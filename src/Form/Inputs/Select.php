<?php

namespace Dobrik\LaravelEasyForm\Forms\Inputs;

use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Select
 * @package App\Helpers\Creator
 */
class Select extends HtmlAbstract
{
    /**
     * @var array
     */
    public $attributes = ['class' => 'form-control', 'values' => []];
    /**
     * @var array
     */
    protected $required_attributes = [
        'name'
    ];

    /**
     * @param string $string
     * @return array|boolean
     */
    private function explodeUserData(string $string)
    {
        $data = [];
        if (Str::startsWith($string, '[') && Str::endsWith($string, ']')) {
            $string = substr($string, 1, strlen($string) - 2);
            $arr = explode(',', $string);
            foreach ($arr as $item) {
                $_arr = explode('=>', $item);
                $key = trim($_arr[0]);
                $value = trim($_arr[1]);
                $value = str_replace("'", "", $value);
                $data[$key] = $value;
            }
        } elseif (Str::startsWith($string, '(') && Str::endsWith($string, ')')) {
            $string = substr($string, 1, strlen($string) - 2);
            $arr = explode('|', $string);
            $table = $arr[0];
            $fields = explode(',', $arr[1]);
            $query_result = \DB::query()->from($table)->get($fields);
            foreach ($query_result as $item) {
                $data[$item->{$fields[0]}] = $item->{$fields[1]};
            }
        }
        return !empty($data) ? $data : false;
    }

    /**
     * @param mixed $value
     * @return HtmlAbstract
     */
    public function setValue($value): HtmlAbstract
    {
        if (\is_array($value)) {
            $value = new Collection($value);
        }

        return parent::setValue($value);
    }

    /**
     * @param array|string $values
     * @return HtmlAbstract
     */
    public function setValues($values): HtmlAbstract
    {
        if (\is_array($values)) {
            $result = $values;
        } elseif (\is_string($values) && $customData = $this->explodeUserData($values)) {
            $result = $customData;
        } else {
            $result = [];
        }
        $this->attributes['values'] = $result;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return ['values' => Arr::pull($this->attributes, 'values')];
    }
}
