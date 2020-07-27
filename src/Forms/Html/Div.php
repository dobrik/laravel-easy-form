<?php

namespace Dobrik\LaravelEasyForm\Forms\Html;

use Dobrik\LaravelEasyForm\Forms\Interfaces\HasContentInterface;
use Dobrik\LaravelEasyForm\Forms\Traits\HasContentTrait;
use Illuminate\Support\Arr;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Div
 * @package Dobrik\LaravelEasyForm\Forms\Html
 */
class Div extends HtmlAbstract implements HasContentInterface
{
    use HasContentTrait;

    public $attributes = ['content' => ''];

    /**
     * @var array
     */
    protected $requiredAttributes = [
        'content'
    ];

    /**
     * Append some strings to template
     * @param array|string $data
     * @return HtmlAbstract
     */
    public function append($data): HtmlAbstract
    {
        if (!Arr::has($this->attributes, 'content')) {
            $this->attributes['content'] = '';
        }

        if (\is_array($data)) {
            foreach ($data as $item) {
                $this->attributes['content'] .= $item;
            }
            return $this;
        }
        $this->attributes['content'] .= $data;


        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return ['content' => $this->pullContent()];
    }
}
