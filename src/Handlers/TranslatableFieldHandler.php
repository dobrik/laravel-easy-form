<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;
use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;
use Illuminate\Contracts\Config\Repository;

class TranslatableFieldHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();

        if (isset($elementConfig['translatable']) && $elementConfig['translatable'] === true) {
            $htmlAbstract = $payload->getHtmlAbstract();
            $payload->setHtmlAbstract(
                $payload->getBuilder()
                    ->buildElement(
                        $this->getFieldTabsConfig(
                            $htmlAbstract,
                            $payload->getElementConfig(),
                            $payload->getContainer()->get(Repository::class)->get('easy_form.config.locales')
                        ),
                        $payload->getData()
                    )
            );
            return $payload;
        }

        return $next($payload);
    }

    protected function getFieldTabsConfig(HtmlAbstract $htmlAbstract, array $fieldConfig, array $locales)
    {
        return [
            'type' => 'Tabs',
            'title' => $htmlAbstract->getTitle(),
            'child' => $this->getTabs($htmlAbstract, $fieldConfig, $locales)
        ];
    }

    protected function getTabs(HtmlAbstract $htmlAbstract, array $fieldConfig, array $locales)
    {
        $tabs = [];
        unset($fieldConfig['translatable']);
        foreach ($locales as $locale) {
            $fieldConfig['title'] = sprintf('%s [%s]', $htmlAbstract->getTitle(), $locale);
            $fieldConfig['name'] = sprintf('%s[%s]', $htmlAbstract->getName(), $locale);
            $tabs[] = [
                'type' => 'Tab',
                'title' => sprintf('%s [%s]', $htmlAbstract->getTitle(), $locale),
                'child' => [
                    $fieldConfig
                ]
            ];
        }
        return $tabs;
    }
}
