<?php

namespace Dobrik\LaravelEasyForm;

use Dobrik\LaravelEasyForm\Exceptions\InvalidFilterException;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Forms\Interfaces\FilterInterface;
use Dobrik\LaravelEasyForm\Models\TranslatableModelAbstract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Closure;

/**
 * Class Generator
 * @package Dobrik\LaravelEasyForm\Forms
 */
class Builder
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var Factory
     */
    protected $factory;

    /** @var Request */
    protected $request;

    /**
     * @var Illuminate\Config\Repository
     */
    protected $configRepository;

    /**
     * Generator constructor.
     * @param Factory $factory
     * @param Illuminate\Config\Repository $configRepository
     */
    public function __construct(Factory $factory, \Illuminate\Config\Repository $configRepository)
    {
        $this->factory = $factory;
        $this->configRepository = $configRepository;

        $this->registerForms();
    }

    public function registerFormConfig(array $config)
    {
        $this->config = array_merge($this->config, $config);
        return $this;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    private function getRequest()
    {
        return $this->request;
    }

    /**
     * @param string $form_name
     * @param null|Model $model
     * @return HtmlAbstract
     * @throws \InvalidArgumentException
     */
    public function create(string $form_name, Model $model = null): HtmlAbstract
    {
        $form_config = $this->getFormConfig($form_name);

        $buttons[] = $this->factory->input('input')->setType('submit')->setName('')->setClass('btn btn-success')->setValue('Save');
        $buttonsBlock = $this->factory->html('div')->setClass('form-group')->setContent($buttons);

        $tabs_main_obj = $this->factory->html('tabs')->setLabel('');

        $main_tabs = [];
        $main_tabs[1] = $this->factory->html('tab')->setId('tab_' . 1)->setTitle('Общее')->setContent('');

        if ($form_config->has('tabs')) {
            $tabs_data = $form_config->get('tabs');

            $tabs_data = array_values(Arr::sort($tabs_data, function ($value) {
                return $value['id'];
            }));

            foreach ($tabs_data as $tab_data) {
                $tab_data = $this->prepareTabConfig($tab_data);
                $tab = $this->factory->html('tab')->setId('tab_' . $tab_data['id'])->setTitle($tab_data['title']);
                if (null === $tab_data['callback']) {
                    foreach ($tab_data['filters'] as $filter) {
                        $filter->apply($tab, $model);
                    }
                } else {
                    $tab_data['callback']($tab, $model);
                }
                $main_tabs[$tab_data['id']] = $tab;
            }
        }

        foreach ($form_config->get('fields') as $field_config) {
            $field_config = $this->prepareFieldConfig($field_config);
            if ($field_config['translatable']) {
                if ($model && !$model instanceof TranslatableModelAbstract) {
                    throw new \InvalidArgumentException(sprintf('Model must be instance of "TranslatableModelAbstract", "%s" given', get_parent_class($model)));
                }
                $field = $this->factory->html('tabs')->setLabel($field_config['title']);
                foreach ($this->configRepository->get('easy_form.config.locales') as $locale) {
                    $fieldObject = $this->prepareField($field_config, $model, $locale);
                    $field->addTab(
                        $this->factory->html('tab')->setTitle($locale)->setId($field_config['name'] . '_' . $locale)->setContent($fieldObject)
                    );
                }
            } else {
                $field = $this->prepareField($field_config, $model);
            }
            $main_tabs[$field_config['tab_id']]->append($field);
        }

        $tabs_main_obj->setTabs($main_tabs);

        $form = $this->factory->input('form');
        $form->setButtons($buttonsBlock)->setContent($tabs_main_obj);

        return $form;
    }

    /**
     * @param string $form_name
     * @return Collection
     * @throws \InvalidArgumentException
     */
    private function getFormConfig(string $form_name): Collection
    {
        if (!isset($this->config[$form_name])) {
            throw new \InvalidArgumentException(sprintf('Unknown form name "%s"', $form_name));
        }
        return collect($this->config[$form_name]);
    }

    /**
     * @param array $field_data
     * @param Model $model
     * @param string|null $locale
     * @return HtmlAbstract
     */
    private function prepareField(array $field_data, Model $model = null, string $locale = null): HtmlAbstract
    {
        $input_name = $locale === null ? $field_data['name'] : $field_data['name'] . '[' . $locale . ']';
        $field = $this->factory->autoMake($input_name, $field_data['type'], $field_data['title']);

        switch (true) {
            case ($value = $this->getRequest()->old(arrayToDot($input_name))) !== null:
                break;
            case $model !== null:
                $value = null === $locale ? $model->getAttribute($field_data['name']) : $model->getLocalizedAttribute($locale, $field_data['name']);
                break;
            default:
                $value = $field_data['default'];
        }

        if (null !== $value) {
            if ($field->getType() === 'checkbox' && $value == 1) {
                $field->setChecked();
            } else {
                $field->setValue($value);
            }
        }

        $field->attributes = array_merge($field->attributes, $field_data['attributes']);
        if ($field_data['callback'] !== null) {
            $field_data['callback']($field, $model);
        }

        /** @var FilterInterface $filter */
        foreach ($field_data['filters'] as $filter) {
            $filter->apply($field, $model);
        }

        foreach ($field_data['plugins'] as $plugin) {
            $field->append($this->factory->plugin($plugin)->setName($input_name)->setParent($field))->setId($field->getId());
        }
        return $field;
    }

    /**
     * Fill required field config
     *
     * @param array $field_config
     * @return array
     */
    private function prepareFieldConfig(array $field_config): array
    {
        if (!array_key_exists('tab_id', $field_config)) {
            $field_config['tab_id'] = 1;
        }
        if (!array_key_exists('translatable', $field_config)) {
            $field_config['translatable'] = false;
        }
        if (!array_key_exists('plugins', $field_config)) {
            $field_config['plugins'] = [];
        }

        if (!array_key_exists('default', $field_config)) {
            $field_config['default'] = null;
        }

        if (!array_key_exists('attributes', $field_config) || !is_array($field_config['attributes'])) {
            $field_config['attributes'] = [];
        }

        if (!array_key_exists('callback', $field_config) || !$field_config['callback'] instanceof Closure) {
            $field_config['callback'] = null;
        }

        $filters = [];
        if (array_key_exists('filters', $field_config)) {
            foreach ((array)$field_config['filters'] as $key => $filter) {
                $filters[] = $this->resolveFilterObject($filter);
            }
        }
        $field_config['filters'] = $filters;

        return $field_config;
    }

    private function registerForms(): void
    {
        foreach ($this->configRepository->get('easy_form.config.forms') as $form) {
            $this->registerFormConfig($this->configRepository->get($form));
        }
    }

    private function resolveFilterObject($filter): FilterInterface
    {
        if (!class_exists($filter)) {
            throw new InvalidFilterException(sprintf('Filter %s does not exists', $filter));
        }

        return new $filter;
    }

    private function prepareTabConfig(array $tab_config)
    {
        if (!array_key_exists('callback', $tab_config) || !$tab_config['callback'] instanceof Closure) {
            $tab_config['callback'] = null;
        }

        $filters = [];
        if (array_key_exists('filters', $tab_config)) {
            foreach ((array)$tab_config['filters'] as $key => $filter) {
                $filters[] = $this->resolveFilterObject($filter);
            }
        }
        $tab_config['filters'] = $filters;

        return $tab_config;
    }
}
