<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;
use Illuminate\Support\Arr;

class CustomAttributesHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();
        if (isset($elementConfig['attributes'])) {
            $htmlAbstract = $payload->getHtmlAbstract();

            $htmlAbstract->setAttributes(
                array_merge($htmlAbstract->getAttributes(), $elementConfig['attributes'])
            );
        }

        return $next($payload);
    }
}
