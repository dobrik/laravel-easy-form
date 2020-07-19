<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;

class ChildHandler implements HandlerInterface
{

    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();
        if (isset($elementConfig['child']) && is_array($elementConfig['child'])) {
            $htmlAbstract = $payload->getHtmlAbstract();
            $htmlAbstract->setContent(
                $payload->getBuilder()
                    ->buildElements(
                        $htmlAbstract,
                        $elementConfig['child'],
                        $payload->getData()
                    )
            );
        }
        return $next($payload);
    }
}
