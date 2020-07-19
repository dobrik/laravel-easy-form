<?php

namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;

interface HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload;
}
