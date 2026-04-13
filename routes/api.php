<?php

use Src\Route;




Route::add('POST', '/auth/register-aspirant', [Controller\Api\AuthApiController::class, 'registerAspirant']);
Route::add('POST', '/auth/register-director', [Controller\Api\AuthApiController::class, 'registerDirector']);
Route::add('POST', '/auth/login', [Controller\Api\AuthApiController::class, 'login']);

// Защищённые маршруты (требуют Bearer токен)
Route::add('GET', '/auth/check', [Controller\Api\AuthApiController::class, 'check'])
    ->middleware('api_auth');
Route::add('POST', '/auth/logout', [Controller\Api\AuthApiController::class, 'logout'])
    ->middleware('api_auth');

// API маршруты для диссертаций (требуют Bearer токен)
Route::add('GET', '/dissertations', [Controller\Api\DissertationApiController::class, 'index'])
    ->middleware('api_auth');
Route::add('GET', '/dissertations/{id}', [Controller\Api\DissertationApiController::class, 'show'])
    ->middleware('api_auth');
Route::add('POST', '/dissertations', [Controller\Api\DissertationApiController::class, 'store'])
    ->middleware('api_auth');
Route::add('POST', '/dissertations/{id}/update', [Controller\Api\DissertationApiController::class, 'update'])
    ->middleware('api_auth');
Route::add('GET', '/dissertations/{id}/delete', [Controller\Api\DissertationApiController::class, 'delete'])
    ->middleware('api_auth');

// API маршруты для публикаций (требуют Bearer токен)
Route::add('GET', '/publications', [Controller\Api\PublicationApiController::class, 'index'])
    ->middleware('api_auth');
Route::add('GET', '/publications/{id}', [Controller\Api\PublicationApiController::class, 'show'])
    ->middleware('api_auth');
Route::add('POST', '/publications', [Controller\Api\PublicationApiController::class, 'store'])
    ->middleware('api_auth');
Route::add('POST', '/publications/{id}/update', [Controller\Api\PublicationApiController::class, 'update'])
    ->middleware('api_auth');
Route::add('GET', '/publications/{id}/delete', [Controller\Api\PublicationApiController::class, 'delete'])
    ->middleware('api_auth');
