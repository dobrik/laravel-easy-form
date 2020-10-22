<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;

class TypeHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        $type = explode(':', $payload->getElementConfig()['type']);
        if (isset($type[1])) {
            $payload->getHtmlAbstract()->setType($type[1]);
        }

        return $next($payload);
    }
}
