<?php


namespace Dobrik\LaravelEasyForm\Handlers;


use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;
use Illuminate\Support\Str;

class SelectValuesHandler implements HandlerInterface
{

    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();
        if (isset($elementConfig['values'])) {
            $htmlAbstract = $payload->getHtmlAbstract();
            $values = $elementConfig['values'];
            if (is_array($values)) {
                $htmlAbstract->setValues($values);
                return $next($payload);
            }

            if (Str::startsWith($values, '(') && Str::endsWith($values, ')')) {
                $htmlAbstract->setValues(
                    $this->getDatabaseData($values)
                );
                return $next($payload);
            }
        }
        return $next($payload);
    }

    /**
     * @param string $string
     * @return array|boolean
     */
    private function getDatabaseData(string $string)
    {
        $string = substr($string, 1, strlen($string) - 2);
        $arr = explode('|', $string);
        $table = $arr[0];
        [$keyField, $valueField] = explode(',', $arr[1]);

        return \DB::query()
            ->from($table)
            ->get([$valueField, $keyField])
            ->pluck($valueField, $keyField)
            ->toArray();
    }
}
