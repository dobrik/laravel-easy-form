<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;

class WrapperClassHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();
        if (isset($elementConfig['wrapper_class'])) {
            $payload->getHtmlAbstract()->setWrapperClass($elementConfig['wrapper_class']);
        }

        return $next($payload);
    }
}
