<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;
use Illuminate\Support\Str;

class IdHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        $htmlAbstract = $payload->getHtmlAbstract();
        if ($htmlAbstract->getId() === null) {
            $htmlAbstract->setId('id_' . Str::random(10));
        }
        return $next($payload);
    }
}
