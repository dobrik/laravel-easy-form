<?php


namespace Dobrik\LaravelEasyForm\Handlers;


use Dobrik\LaravelEasyForm\Handlers\Payload\Payload;

class PluginsHandler implements HandlerInterface
{

    public function handle(Payload $payload, \Closure $next): Payload
    {
        $elementConfig = $payload->getElementConfig();
        if (isset($elementConfig['plugins']) && is_array($elementConfig['plugins'])) {
            $htmlAbstract = $payload->getHtmlAbstract();
            foreach ($elementConfig['plugins'] as $key => $value) {
                $attributes = [];
                $plugin = $value;
                if (is_array($value)) {
                    $attributes = $value;
                    $plugin = $key;
                }
                $htmlAbstract->append(
                    $payload->getBuilder()
                        ->getFactory()
                        ->plugin($plugin)
                        ->mergeAttributes($attributes)
                        ->setParent($htmlAbstract)
                );
            }
        }
        return $next($payload);
    }
}
