<?php

namespace Dobrik\LaravelEasyForm\Forms\Traits;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Illuminate\Support\Arr;

/**
 * Class HasContentTrait
 * @package Dobrik\LaravelEasyForm\Forms\Traits
 * @property array $attributes
 */
trait HasContentTrait
{
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
}
