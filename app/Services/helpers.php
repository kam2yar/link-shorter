<?php

if (!function_exists('base_url')) {
    function base_url(): string
    {
        return sprintf(
            "%s://%s/",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'] . (in_array($_SERVER["SERVER_PORT"], [443, 80]) ? '' : ':' . $_SERVER["SERVER_PORT"])
        );
    }
}

if (!function_exists('now')) {
    function now()
    {
        return date('Y-m-d H:i:s');
    }
}