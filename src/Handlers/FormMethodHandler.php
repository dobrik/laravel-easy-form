<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;

class FormMethodHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();
        if (isset($elementConfig['method']) && !empty($elementConfig['method'])) {
            $htmlAbstract = $payload->getHtmlAbstract();

            $htmlAbstract->setMethod($elementConfig['method']);

        }
        return $next($payload);
    }
}
