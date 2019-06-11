<?php

namespace Dobrik\LaravelEasyForm\Forms\Html;

use Illuminate\Support\Str;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

/**
 * Class Tabs
 * @package Dobrik\LaravelEasyForm\Forms\Html
 */
class Tabs extends HtmlAbstract
{
    /**
     * @var array
     */
    public $attributes = ['class' => 'nav-tabs-custom'];

    /**
     * @var array
     */
    protected $required_attributes = [
        'label'
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
     * @return void
     */
    private function checkActive(): void
    {
        $has_active = false;
        foreach ($this->tabs as $key => $tab) {
            if (Str::contains($tab->getClass(), 'active')) {
                $has_active = true;
                break;
            }
        }
        if (!$has_active) {
            $this->tabs[0]->setClass('active');
        }
    }

    /**
     * @param array $tabs
     * @return HtmlAbstract
     */
    public function setTabs(array $tabs): HtmlAbstract
    {
        if (\is_array($tabs)) {
            foreach ($tabs as $tab) {
                if ($tab instanceof Tab) {
                    $this->tabs[] = $tab;
                }
            }
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
