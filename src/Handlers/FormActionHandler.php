<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;
use Illuminate\Routing\UrlGenerator;

class FormActionHandler implements HandlerInterface
{

    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();
        if (isset($elementConfig['action']) && !empty($elementConfig['action'])) {
            $htmlAbstract = $payload->getHtmlAbstract();

            $htmlAbstract->setAction($elementConfig['action']);

            return $next($payload);
        }
        if (isset($elementConfig['route']) && !empty($elementConfig['route'])) {
            $htmlAbstract = $payload->getHtmlAbstract();

            $htmlAbstract->setAction(
                $payload->getContainer()
                    ->make(UrlGenerator::class)
                    ->route($elementConfig['route'])
            );

            return $next($payload);
        }
        return $next($payload);
    }
}
