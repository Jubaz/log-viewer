<?php

if (!function_exists('registeredModules')) {
    function registeredModules()
    {
        return [
            'Log',
        ];
    }
}

if (!function_exists('ApiV1Prefix')) {
    function ApiV1Prefix()
    {
        return 'V1';
    }
}