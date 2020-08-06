<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;

class DefaultValueHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();
        $htmlAbstract = $payload->getHtmlAbstract();
        if (isset($elementConfig['default']) && empty($payload->getData())) {
            $htmlAbstract->setValue($elementConfig['default']);
        }

        return $next($payload);
    }
}
