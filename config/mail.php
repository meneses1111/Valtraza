<?php

$host = env('MAIL_HOST', '127.0.0.1');
$password = env('MAIL_PASSWORD');

return [
    'default' => env('MAIL_MAILER', 'smtp'),
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'scheme' => env('MAIL_SCHEME'),
            'host' => $host,
            'port' => env('MAIL_PORT', 587),
            'username' => env('MAIL_USERNAME'),
            'password' => $host === 'smtp.gmail.com' && is_string($password) ? preg_replace('/\s+/', '', $password) : $password,
            'timeout' => 5,
        ],
        'array' => ['transport' => 'array'],
    ],
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'notificaciones@valtraza.test'),
        'name' => env('MAIL_FROM_NAME', 'Valtraza'),
    ],
];
