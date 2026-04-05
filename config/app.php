<?php
return [
  'auth' => \Src\Auth\Auth::class,
  'identity'=> \Model\User::class,
    'routeMiddleware'=> [
        'auth'=>\Middleware\AuthMiddleware::class,
    ]
];