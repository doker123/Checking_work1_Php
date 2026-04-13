<?php

namespace Controller\Api;

use Model\Aspirant;
use Model\ScientificDirector;
use Model\ApiToken;
use Src\Request;
use Src\View;
use Src\Validator\Validator;

class AuthApiController
{
    /**
     * Генерация случайного токена
     */
    private function generateToken(): string
    {
        return bin2hex(random_bytes(64));
    }

    /**
     * Регистрация аспиранта через API
     * POST /api/auth/register-aspirant
     */
    public function registerAspirant(Request $request): void
    {
        $validator = new Validator($request->all(), [
            'login' => ['required', 'min:3'],
            'password' => ['required', 'min:6'],
            'name' => ['required'],
            'patronum' => ['required'],
            'last_name' => ['required'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'numeric'],
            'citizenship' => ['required'],
            'identity_document' => ['required'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
            'date' => 'Поле :field должно быть датой в формате YYYY-MM-DD',
            'numeric' => 'Поле :field должно быть числом',
            'min' => 'Поле :field должно содержать минимум :min символов',
        ]);

        if ($validator->fails()) {
            (new View())->toJSON([
                'error' => 'Ошибка валидации',
                'messages' => array_merge(...array_values($validator->errors())),
            ], 422);
        }

        // Проверка уникальности логина
        $exists = Aspirant::where('login', $request->login)->first();
        if ($exists) {
            (new View())->toJSON([
                'error' => 'Пользователь с таким логином уже существует',
            ], 422);
        }

        $aspirant = Aspirant::create([
            'login' => $request->login,
            'password' => $request->password,
            'name' => $request->name,
            'patronum' => $request->patronum,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'citizenship' => $request->citizenship,
            'identity_document' => $request->identity_document,
        ]);

        // Генерируем токен
        $token = $this->generateToken();
        ApiToken::create([
            'user_id' => $aspirant->aspirant_id,
            'user_type' => 'aspirant',
            'token' => $token,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        (new View())->toJSON([
            'message' => 'Аспирант успешно зарегистрирован',
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
            'user' => [
                'aspirant_id' => $aspirant->aspirant_id,
                'login' => $aspirant->login,
                'full_name' => $aspirant->full_name,
                'user_type' => 'aspirant',
            ],
        ], 201);
    }

    /**
     * Регистрация научного руководителя через API
     * POST /api/auth/register-director
     */
    public function registerDirector(Request $request): void
    {
        $validator = new Validator($request->all(), [
            'login' => ['required', 'min:3'],
            'password' => ['required', 'min:6'],
            'name' => ['required'],
            'patronum' => ['required'],
            'last_name' => ['required'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'numeric'],
            'citizenship' => ['required'],
            'academic_degree' => ['required'],
            'title_id' => ['required', 'numeric'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
            'date' => 'Поле :field должно быть датой в формате YYYY-MM-DD',
            'numeric' => 'Поле :field должно быть числом',
            'min' => 'Поле :field должно содержать минимум :min символов',
        ]);

        if ($validator->fails()) {
            (new View())->toJSON([
                'error' => 'Ошибка валидации',
                'messages' => array_merge(...array_values($validator->errors())),
            ], 422);
        }

        // Проверка уникальности логина
        $exists = ScientificDirector::where('login', $request->login)->first();
        if ($exists) {
            (new View())->toJSON([
                'error' => 'Пользователь с таким логином уже существует',
            ], 422);
        }

        $director = ScientificDirector::create([
            'login' => $request->login,
            'password' => $request->password,
            'name' => $request->name,
            'patronum' => $request->patronum,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'citizenship' => $request->citizenship,
            'academic_degree' => $request->academic_degree,
            'title_id' => $request->title_id,
        ]);

        // Генерируем токен
        $token = $this->generateToken();
        ApiToken::create([
            'user_id' => $director->director_id,
            'user_type' => 'director',
            'token' => $token,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        (new View())->toJSON([
            'message' => 'Научный руководитель успешно зарегистрирован',
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
            'user' => [
                'director_id' => $director->director_id,
                'login' => $director->login,
                'full_name' => $director->full_name,
                'academic_degree' => $director->academic_degree,
                'user_type' => 'director',
            ],
        ], 201);
    }

    /**
     * Авторизация через API — выдача Bearer токена
     * POST /api/auth/login
     */
    public function login(Request $request): void
    {
        $validator = new Validator($request->all(), [
            'login' => ['required'],
            'password' => ['required'],
            'user_type' => ['required'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
        ]);

        if ($validator->fails()) {
            (new View())->toJSON([
                'error' => 'Ошибка валидации',
                'messages' => array_merge(...array_values($validator->errors())),
            ], 422);
        }

        $credentials = [
            'login' => $request->login,
            'password' => $request->password,
        ];

        // Определяем класс по user_type
        $userClass = match ($request->user_type) {
            'aspirant' => Aspirant::class,
            'director' => ScientificDirector::class,
            default => null,
        };

        if (!$userClass) {
            (new View())->toJSON([
                'error' => 'Неверный тип пользователя. Допустимые: aspirant, director',
            ], 422);
        }

        $user = (new $userClass())->attemptIdentity($credentials);

        if (!$user) {
            (new View())->toJSON([
                'error' => 'Неверный логин или пароль',
            ], 401);
        }

        // Аннулируем старые токены пользователя
        $primaryKey = $request->user_type === 'aspirant' ? 'aspirant_id' : 'director_id';
        ApiToken::where('user_id', $user->getId())
            ->where('user_type', $request->user_type)
            ->delete();

        // Генерируем новый токен
        $token = $this->generateToken();
        ApiToken::create([
            'user_id' => $user->getId(),
            'user_type' => $request->user_type,
            'token' => $token,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        (new View())->toJSON([
            'message' => 'Авторизация успешна',
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
            'user' => [
                'user_id' => $user->getId(),
                'user_type' => $request->user_type,
                'full_name' => $user->getDisplayName(),
            ],
        ]);
    }

    /**
     * Проверка текущего токена
     * GET /api/auth/check (требует Bearer токен)
     */
    public function check(Request $request): void
    {
        $user = $request->api_user ?? null;
        $userType = $request->api_user_type ?? null;

        if (!$user) {
            (new View())->toJSON([
                'authenticated' => false,
                'message' => 'Пользователь не авторизован',
            ], 401);
        }

        (new View())->toJSON([
            'authenticated' => true,
            'user_id' => $user->getId(),
            'user_type' => $userType,
            'full_name' => $user->getDisplayName(),
        ]);
    }

    /**
     * Отозвать токен (выход)
     * POST /api/auth/logout (требует Bearer токен)
     */
    public function logout(Request $request): void
    {
        $tokenId = $request->api_token_id ?? null;

        if ($tokenId) {
            $token = ApiToken::find($tokenId);
            if ($token) {
                $token->delete();
            }
        }

        (new View())->toJSON([
            'message' => 'Токен отозван, выход выполнен',
        ]);
    }
}
