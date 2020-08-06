<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;

class TitleHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();
        if (isset($elementConfig['title'])) {
            $payload
                ->getHtmlAbstract()
                ->setTitle($elementConfig['title']);
        }
        return $next($payload);
    }
}
