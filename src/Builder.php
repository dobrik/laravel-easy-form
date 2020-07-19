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
        foreach ($this->configRepository->get('easy_form.config.forms') as $form) {
            $this->registerFormConfig($this->configRepository->get($form));
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

        $pipeline = new Pipeline($this->container);
        return $pipeline
            ->send(
                new Payload($this->getContainer(), $htmlAbstract, $this, $elementConfig, $data)
            )
            ->via('handle')
            ->through(
                $this->getHandlersFor($htmlAbstract)
            )
            ->then(function (Payload $payload) {
                return $payload;
            })
            ->getHtmlAbstract();
    }

    protected function getHandlersFor(HtmlAbstract $htmlAbstract): array
    {
        $handlers = $this->configRepository->get('easy_form.handlers.common', []);

        $types = $this->configRepository->get('easy_form.handlers.types', []);
        $handlersForType = [];
        foreach ($types as $applyTo => $applyHandlers) {
            if ($htmlAbstract instanceof $applyTo) {
                $handlersForType[] = $applyHandlers;
            }
        }

        return array_unique(array_merge($handlers, ...$handlersForType));
    }
}
