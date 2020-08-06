<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;

class NameHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();
        if (isset($elementConfig['name'])) {
            $htmlAbstract = $payload->getHtmlAbstract();
            $htmlAbstract->setName($elementConfig['name']);
        }

        return $next($payload);
    }
}
