<?php

namespace Middleware;

use Src\Request;
use Src\View;
use Model\ApiToken;
use Model\Aspirant;
use Model\ScientificDirector;

class ApiAuthMiddleware
{
    public function handle(Request $request): Request
    {
        $authHeader = $request->headers['Authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? '';

        if (empty($authHeader)) {
            (new View())->toJSON([
                'error' => 'Отсутствует заголовок Authorization',
            ], 401);
        }

        if (!preg_match('/^Bearer\s+(.+)$/i', $authHeader, $matches)) {
            (new View())->toJSON([
                'error' => 'Неверный формат заголовка Authorization. Ожидается: Bearer <token>',
            ], 401);
        }

        $tokenString = $matches[1];

        $apiToken = ApiToken::where('token', $tokenString)->first();

        if (!$apiToken) {
            (new View())->toJSON([
                'error' => 'Неверный токен',
            ], 401);
        }

        if ($apiToken->isExpired()) {
            (new View())->toJSON([
                'error' => 'Токен истёк',
            ], 401);
        }

        // Определяем пользователя по типу
        $userClass = match ($apiToken->user_type) {
            'aspirant' => Aspirant::class,
            'director' => ScientificDirector::class,
            default => null,
        };

        if (!$userClass) {
            (new View())->toJSON([
                'error' => 'Неверный тип пользователя в токене',
            ], 401);
        }

        $user = $userClass::find($apiToken->user_id);

        if (!$user) {
            (new View())->toJSON([
                'error' => 'Пользователь не найден',
            ], 401);
        }

        // Сохраняем найденного пользователя в запрос для контроллера
        $request->set('api_user', $user);
        $request->set('api_user_type', $apiToken->user_type);
        $request->set('api_token_id', $apiToken->id);

        return $request;
    }
}
