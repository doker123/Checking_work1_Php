<?php

return [
    'auth' => \Src\Auth\Auth::class,
    'identity' => \Src\Auth\IdentityProvider::class,
    'routeMiddleware' => [
        'auth' => \Middleware\AuthMiddleware::class,
        'role' => \Middleware\RoleMiddleware::class,
    ],
];
