<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;

class ContentHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();
        $htmlAbstract = $payload->getHtmlAbstract();

        if (isset($elementConfig['content'])) {
            $htmlAbstract->setContent($elementConfig['content']);
        }

        return $next($payload);
    }
}
