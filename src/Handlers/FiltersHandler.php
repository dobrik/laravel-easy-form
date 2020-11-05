<?php


namespace Dobrik\LaravelEasyForm\Handlers;


use Dobrik\LaravelEasyForm\Exceptions\InvalidFilterException;
use Dobrik\LaravelEasyForm\Forms\Interfaces\FilterInterface;
use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;

class FiltersHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();
        if (isset($elementConfig['filters']) && is_array($elementConfig['filters'])) {
            $htmlAbstract = $payload->getHtmlAbstract();
            foreach ($elementConfig['filters'] as $key => $value) {
                $parameters = [];
                $filter = $value;
                if (is_array($value)) {
                    $parameters = $value;
                    $filter = $key;
                }
                $payload = $next($payload);
                $this->resolveFilterObject($filter, $payload)->apply($htmlAbstract, $payload->getData(), $parameters);
                return $payload;
            }
        }
        return $next($payload);
    }

    private function resolveFilterObject($filter, Payload $payload): FilterInterface
    {
        if (!class_exists($filter)) {
            throw new InvalidFilterException(sprintf('Filter %s does not exists', $filter));
        }

        return $payload->getContainer()->make($filter);
    }
}
