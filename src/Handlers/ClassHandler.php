<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;

class ClassHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();
        $htmlAbstract = $payload->getHtmlAbstract();

        if (isset($elementConfig['class']) && $htmlAbstract->getClass() === null) {
            $htmlAbstract->setClass($elementConfig['class']);
        }

        return $next($payload);
    }
}
