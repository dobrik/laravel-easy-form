<?php

namespace Dobrik\LaravelEasyForm;

use Dobrik\LaravelEasyForm\DataMappers\DataMapperInterface;
use Dobrik\LaravelEasyForm\Exceptions\InvalidElementConfigException;
use Dobrik\LaravelEasyForm\Forms\Html\Form;
use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;
use \Illuminate\Config\Repository;
use \Illuminate\Container\Container;
use \Illuminate\Http\Request;
use \Illuminate\Pipeline\Pipeline;
use \Illuminate\Support\Collection;

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

    /** @var Repository */
    protected $configRepository;

    /**  @var Container */
    private $container;

    /**
     * Generator constructor.
     * @param Container $container
     * @param Factory $factory
     * @param Repository $configRepository
     */
    public function __construct(Container $container, Factory $factory, Repository $configRepository)
    {
        $this->container = $container;
        $this->factory = $factory;
        $this->configRepository = $configRepository;

        $this->registerForms();
    }

    public function registerFormConfig(array $config)
    {
        $this->config = array_merge($this->config, $config);
        return $this;
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

    private function registerForms(): void
    {
        foreach ($this->getConfigRepository()->get('easy_form.config.forms') as $form) {
            $this->registerFormConfig($this->getConfigRepository()->get($form));
        }
    }

    /**
     * @return Factory
     */
    public function getFactory(): Factory
    {
        return $this->factory;
    }

    /** @return Container */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @return Repository
     */
    public function getConfigRepository(): Repository
    {
        return $this->configRepository;
    }

    /**
     * @param string $formName
     * @param DataMapperInterface $dataMapper
     * @return Form
     */
    public function create(string $formName, DataMapperInterface $dataMapper = null): Form
    {
        $formConfig = $this->getFormConfig($formName)->toArray();
        $formConfig['type'] = 'Form';

        return $this->buildElement($formConfig, $dataMapper ? $dataMapper->mapToForm() : []);
    }

    public function buildElements(HtmlAbstract $parent, array $elementsConfig, $data = []): array
    {
        $elements = [];
        foreach ($elementsConfig as $elementConfig) {
            $elements[] = $this->buildElement($elementConfig, $data)->setParent($parent);
        }

        return $elements;
    }

    /**
     * @param array $elementConfig
     * @param array $data
     * @return mixed
     * @throws Exceptions\InvalidAliasException | InvalidElementConfigException
     * @throws \Throwable
     */
    public function buildElement(array $elementConfig, $data = []): HtmlAbstract
    {
        throw_if(!isset($elementConfig['type']), new InvalidElementConfigException('Element has no required "type" field.'));
        $htmlAbstract = $this->getFactory()->html(explode(':', $elementConfig['type'])[0]);
        $elementConfig = array_merge(
            $this->getDefaultsFor($htmlAbstract),
            $elementConfig
        );

        $payload = new Payload($this->getContainer(), $htmlAbstract, $this, $elementConfig, $data);
        $htmlAbstract->setPayload($payload);
        $pipeline = new Pipeline($this->container);
        return $pipeline
            ->send($payload)
            ->via('handle')
            ->through(
                $this->getHandlersFor($htmlAbstract)
            )
            ->then(function (Payload $payload) {
                return $payload;
            })
            ->getHtmlAbstract();
    }

    /**
     * @param HtmlAbstract $htmlAbstract
     * @param string $config
     * @return array
     */
    protected function getConfigFor(HtmlAbstract $htmlAbstract, string $config): array
    {
        $handlers = $this->getConfigRepository()->get('easy_form.' . $config . '.common', []);
        $types = $this->getConfigRepository()->get('easy_form.' . $config . '.types', []);

        $handlersForType = [];
        foreach ($types as $applyTo => $applyHandlers) {
            if ($htmlAbstract instanceof $applyTo) {
                $handlersForType[] = $applyHandlers;
            }
        }

        return array_unique(array_merge($handlers, ...$handlersForType));
    }

    /**
     * @param HtmlAbstract $htmlAbstract
     * @return array
     */
    protected function getHandlersFor(HtmlAbstract $htmlAbstract): array
    {
        return $this->getConfigFor($htmlAbstract, 'handlers');
    }

    /**
     * @param HtmlAbstract $htmlAbstract
     * @return array
     */
    protected function getDefaultsFor(HtmlAbstract $htmlAbstract): array
    {
        return $this->getConfigFor($htmlAbstract, 'defaults');
    }
}
