<?php

namespace Controller;

use Model\Post;
use Model\Admin;
use Model\Aspirant;
use Model\ScientificDirector;
use Model\AcademicTitle;
use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Src\Session;
use Src\Validator\Validator;

class Site
{
    public function signup(Request $request): string
    {
        if ($request->method === 'GET') {
            $titles = AcademicTitle::all();
            return new View('site.signup', ['titles' => $titles]);
        }

        if (!hash_equals(Session::get('csrf_token') ?? '', $request->csrf_token ?? '')) {
            $titles = AcademicTitle::all();
            return new View('site.signup', ['errors' => ['Неверный CSRF-токен'], 'titles' => $titles]);
        }

        $rules = [
            'user_type' => ['required'],
            'login' => ['required'],
            'password' => ['required'],
            'name' => ['required'],
        ];

        $validator = null;

        // Добавляем правила в зависимости от роли
        if ($request->user_type === 'director') {
            $directorRules = [
                'director_last_name' => ['required'],
                'director_patronum' => ['required'],
                'director_date_of_birth' => ['required'],
                'director_gender' => ['required'],
                'director_citizenship' => ['required'],
            ];
            $allRules = array_merge($rules, $directorRules);
            $validator = new Validator($request->all(), $allRules, [
                'required' => 'Поле :field обязательно для заполнения',
            ]);
        } elseif ($request->user_type === 'aspirant') {
            $aspirantRules = [
                'aspirant_last_name' => ['required'],
                'aspirant_patronum' => ['required'],
                'aspirant_date_of_birth' => ['required'],
                'aspirant_gender' => ['required'],
                'aspirant_citizenship' => ['required'],
                'aspirant_identity_document' => ['required'],
            ];
            $allRules = array_merge($rules, $aspirantRules);
            $validator = new Validator($request->all(), $allRules, [
                'required' => 'Поле :field обязательно для заполнения',
            ]);
        } else {
            // Для admin только базовые правила
            $validator = new Validator($request->all(), $rules, [
                'required' => 'Поле :field обязательно для заполнения',
            ]);
        }

        if ($validator->fails()) {
            $titles = AcademicTitle::all();
            return new View('site.signup', [
                'errors' => array_merge(...array_values($validator->errors())),
                'data' => $request->all(),
                'titles' => $titles,
            ]);
        }

        $errors = [];

        $login = $request->login;
        $exists =
            Admin::where('login', $login)->exists() ||
            Aspirant::where('login', $login)->exists() ||
            ScientificDirector::where('login', $login)->exists();

        if ($exists) {
            $errors[] = 'Пользователь с таким логином уже существует';
        }

        if (!empty($errors)) {
            $titles = AcademicTitle::all();
            return new View('site.signup', ['errors' => $errors, 'data' => $request->all(), 'titles' => $titles]);
        }

        match ($request->user_type) {
            'admin' => Admin::create([
                'login' => $login,
                'password' => $request->password,
                'name' => $request->name ?? 'Администратор',
            ]),
            'aspirant' => Aspirant::create([
                'login' => $login,
                'password' => $request->password,
                'name' => $request->name ?? '',
                'patronum' => $request->aspirant_patronum ?? '',
                'last_name' => $request->aspirant_last_name ?? '',
                'date_of_birth' => $request->aspirant_date_of_birth ?? date('Y-m-d'),
                'gender' => $request->aspirant_gender ?? 1,
                'citizenship' => $request->aspirant_citizenship ?? 'РФ',
                'identity_document' => $request->aspirant_identity_document ?? 'Паспорт',
            ]),
            'director' => ScientificDirector::create([
                'login' => $login,
                'password' => $request->password,
                'name' => $request->name ?? '',
                'patronum' => $request->director_patronum ?? '',
                'last_name' => $request->director_last_name ?? '',
                'date_of_birth' => $request->director_date_of_birth ?? date('Y-m-d'),
                'gender' => $request->director_gender ?? 1,
                'citizenship' => $request->director_citizenship ?? 'РФ',
                'academic_degree' => $request->director_academic_degree ?? '',
                'title_id' => $request->director_title_id ?: null,
            ]),
            default => null,
        };

        app()->route->redirect('/login');
        return '';
    }

    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return (new View('site.login'))->render();
        }

        if (!hash_equals(Session::get('csrf_token') ?? '', $request->csrf_token ?? '')) {
            return new View('site.login', ['message' => 'Неверный CSRF-токен']);
        }

        if (Auth::attempt($request->all())) {
            $userType = Auth::getUserType();
            match ($userType) {
                'admin' => app()->route->redirect('/admin/aspirants'),
                'director' => app()->route->redirect('/admin/dissertations'),
                'aspirant' => app()->route->redirect('/admin/publications'),
                default => app()->route->redirect('/'),
            };
            return '';
        }

        return (new View('site.login', ['message' => 'Неверный логин или пароль']))->render();
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/login');
        exit;
    }
}
