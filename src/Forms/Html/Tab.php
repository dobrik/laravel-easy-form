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
        'title', 'id'
    ];

    public $attributes = [
        'class' => 'nav-items'
    ];

    public $content;

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
                $this->content .= $item;
            }
            return $this;
        }
        $this->content .= $data;

        return $this;
    }

    public function setContent($data)
    {
        $this->content = $data;
        return $this;
    }

    public function getContent()
    {
        return $this->content;
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
        $this->attributes['class'] .= ' tab-pane fade';
    }

    /**
     * @throws \Throwable
     * @return array
     */
    public function getData(): array
    {
        $this->prepareTabClass();
        return ['content' => $this->getContent()];
    }
}
