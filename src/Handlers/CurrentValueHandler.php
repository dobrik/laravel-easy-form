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
            $htmlAbstract->setValue(
                $this->getFieldValue($htmlAbstract->getName(), $payload->getData())
            );
        }

        return $next($payload);
    }

    protected function getFieldValue($name, $data)
    {
        $dotStyleArrayData = Arr::dot($data);
        return $dotStyleArrayData[arrayToDot($name)] ?? '';
    }
}
