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
        'class' => 'tab-pane'
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
     * @throws \Throwable
     * @return array
     */
    public function getData(): array
    {
        return ['content' => $this->getContent()];
    }
}
