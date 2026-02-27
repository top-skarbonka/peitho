<?php

return [
    'enabled' => (bool) env('SMSAPI_ENABLED', true),
    'token'   => env('SMSAPI_TOKEN'),
    'from'    => env('SMSAPI_FROM', 'ECO'),
];
