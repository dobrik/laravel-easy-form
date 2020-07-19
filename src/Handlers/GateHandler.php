<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;
use Illuminate\Contracts\Auth\Access\Gate;

class GateHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();
        if (isset($elementConfig['can'])) {
            if ($payload->getContainer()->get(Gate::class)->denies($elementConfig['can'])) {
                $payload->setHtmlAbstract(
                    $payload->getBuilder()
                        ->getFactory()
                        ->html('div')
                        ->setContent('')
                );
                return $payload;
            }
        }
        return $next($payload);
    }
}
