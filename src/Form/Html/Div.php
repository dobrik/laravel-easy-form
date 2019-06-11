<?php

namespace Dobrik\LaravelEasyForm\Forms\Html;

use Illuminate\Support\Arr;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Div
 * @package Dobrik\LaravelEasyForm\Forms\Html
 */
class Div extends HtmlAbstract
{
    /**
     * @var array
     */
    protected $required_attributes = [
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
     * @param array|string $content
     * @return $this
     */
    public function setContent($content): HtmlAbstract
    {
        if (\is_array($content)) {
            if (!Arr::has($this->attributes, 'content')) {
                $this->attributes['content'] = '';
            }

            foreach ($content as $item) {
                $this->attributes['content'] .= $item;
            }
        } else {
            $this->attributes['content'] = $content;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return ['content' => Arr::pull($this->attributes, 'content')];
    }
}
