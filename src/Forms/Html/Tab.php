<?php

namespace Dobrik\LaravelEasyForm\Forms\Html;

use Illuminate\Support\Arr;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Tab
 * @package Dobrik\LaravelEasyForm\Forms\Html
 */
class Tab extends HtmlAbstract
{
    /**
     * @var array
     */
    protected $required_attributes = [
        'content', 'title', 'id'
    ];

    /**
     * @param array|string $data
     * @return HtmlAbstract
     */
    public function append($data): HtmlAbstract
    {
        if (null === $this->getContent()) {
            $this->setContent('');
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
     * Add tabs plugin class.
     * @throws \Throwable
     * @return void
     */
    private function prepareTabClass(): void
    {
        if (null === $this->getClass()) {
            $this->setClass('');
        }
        $this->attributes['class'] .= ' tab-pane';
    }

    /**
     * @throws \Throwable
     * @return array
     */
    public function getData(): array
    {
        $this->prepareTabClass();
        return ['content' => Arr::pull($this->attributes, 'content')];
    }
}
