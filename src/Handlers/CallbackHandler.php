<?php


namespace Dobrik\LaravelEasyForm\Handlers;


use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;

class CallbackHandler implements HandlerInterface
{

    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();
        if (isset($elementConfig['callback']) && $elementConfig['callback'] instanceof \Closure) {
            $elementConfig['callback']($payload->getHtmlAbstract(), $payload->getData());
        }
        return $next($payload);
    }
}
