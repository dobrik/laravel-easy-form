<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Exceptions\InvalidElementConfigException;
use Dobrik\LaravelEasyForm\Exceptions\InvalidElementException;
use Dobrik\LaravelEasyForm\Forms\Html\Template;
use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;

class TemplateHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        $htmlAbstract = $payload->getHtmlAbstract();
        if (!$htmlAbstract instanceof Template) {
            throw new InvalidElementException(sprintf('TemplateHandler can only applied to "Template" class, "%s" given', get_class($htmlAbstract)));
        }
        $templateData = $payload->getBuilder()->getConfigRepository()->get('easy_form.templates.' . $htmlAbstract->getName(), null);
        if (empty($templateData)) {
            throw new InvalidElementConfigException(sprintf('Template config "%s" is empty or not exist.', $htmlAbstract->getName()));
        }
        $htmlAbstract->setContent(
            $payload->getBuilder()
                ->buildElement($templateData)
        );
        return $next($payload);
    }
}
