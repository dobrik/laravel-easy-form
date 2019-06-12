<?php

if (!function_exists('arrayToDot')) {
    /**
     * Change input name from array style to dot notation style
     * @param string $name
     * @return string
     */
    function arrayToDot(string $name)
    {
        if (\Illuminate\Support\Str::contains($name, '[') && \Illuminate\Support\Str::contains($name, ']')) {
            $name = str_replace(array(']', '['), array('', '.'), $name);
        }

        return $name;
    }
}