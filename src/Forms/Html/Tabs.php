<?php

namespace Dobrik\LaravelEasyForm\Forms\Html;

use Dobrik\LaravelEasyForm\Exceptions\InvalidElementException;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Forms\Interfaces\HasContentInterface;

/**
 * Class Tabs
 * @package Dobrik\LaravelEasyForm\Forms\Html
 */
class Tabs extends HtmlAbstract implements HasContentInterface
{
    /**
     * @var array
     */
    public $attributes = ['class' => 'nav nav-tabs'];

    /**
     * @var array
     */
    protected $requiredAttributes = [
        'title'
    ];

    /**
     * @var array
     */
    private $tabs = [];

    /**
     * @param Tab $tab
     * @return $this
     */
    public function addTab(Tab $tab)
    {
        $this->tabs[] = $tab;
        return $this;
    }

    /**
     * @return integer
     */
    public function count(): int
    {
        return \count($this->tabs);
    }

    /**
     * @param array $tabs
     * @return HtmlAbstract
     */
    public function setTabs(array $tabs): HtmlAbstract
    {
        foreach ($tabs as $tab) {
            if (!$tab instanceof Tab) {
                throw new InvalidElementException(sprintf('Expected instance of "Dobrik\LaravelEasyForm\Forms\Html\Tab", "%s" given', get_class($tab)));
            }
            $this->tabs[] = $tab;
        }

        return $this;
    }

    /**
     * @return void
     */
    private function checkActive(): void
    {
        foreach ($this->tabs as $key => $tab) {
            $tab->setClass($tab->getClass() . ' active');
            break;
        }
    }

    public function setContent($content): HtmlAbstract
    {
        if (\is_array($content)) {
            $this->setTabs($content);
        } else {
            $this->addTab($content);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $this->checkActive();
        return ['tabs' => $this->tabs];
    }
}
