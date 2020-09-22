<?php


namespace Dobrik\LaravelEasyForm\Handlers;

use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;
use Illuminate\Support\Arr;

class CurrentValueHandler implements HandlerInterface
{
    public function handle(Payload $payload, \Closure $next): Payload
    {
        if (!empty($payload->getData())) {
            $htmlAbstract = $payload->getHtmlAbstract();
            $value = $this->getFieldValue($htmlAbstract->getName(), $payload->getData());
            if(!empty($value)) {
                $htmlAbstract->setValue($value);
            }
        }

        return $next($payload);
    }

    protected function getFieldValue($name, $data)
    {
        $name = arrayToDot($name);
        return Arr::get($data, $name) ?? $data[$name] ?? null;
    }
}
