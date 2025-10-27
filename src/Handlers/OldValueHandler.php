<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;
use Illuminate\Http\Request;

class OldValueHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        $htmlAbstract = $payload->getHtmlAbstract();
        $oldValue = $payload->getContainer()->make(Request::class)->old(arrayToDot($htmlAbstract->getName()));
        if (isset($oldValue)) {
            $htmlAbstract->setValue($oldValue);
        }

        return $next($payload);
    }
}
