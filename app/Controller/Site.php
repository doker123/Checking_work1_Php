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

class Site
{
    public function signup(Request $request): string
    {
        if ($request->method === 'GET') {
            $titles = AcademicTitle::all();
            return new View('site.signup', ['titles' => $titles]);
        }

        $errors = [];

        if (empty($request->login) || empty($request->password)) {
            $errors[] = 'Логин и пароль обязательны';
        }

        if (empty($request->user_type)) {
            $errors[] = 'Выберите роль';
        }

        $login = $request->login;
        $exists =
            Admin::where('login', $login)->exists() ||
            Aspirant::where('login', $login)->exists() ||
            ScientificDirector::where('login', $login)->exists();

        if ($exists) {
            $errors[] = 'Пользователь с таким логином уже существует';
        }

        if (!empty($errors)) {
            return new View('site.signup', ['errors' => $errors, 'data' => $request->all()]);
        }

        $hashedPassword = password_hash($request->password, PASSWORD_DEFAULT);

        match ($request->user_type) {
            'admin' => Admin::create([
                'login' => $login,
                'password' => $hashedPassword,
                'name' => $request->name ?? 'Администратор',
            ]),
            'aspirant' => Aspirant::create([
                'login' => $login,
                'password' => $hashedPassword,
                'name' => $request->name ?? '',
                'patronum' => $request->patronum ?? '',
                'last_name' => $request->last_name ?? '',
                'date_of_birth' => $request->date_of_birth ?? date('Y-m-d'),
                'gender' => $request->gender ?? 1,
                'citizenship' => $request->citizenship ?? 'РФ',
                'identity_document' => $request->identity_document ?? 'Паспорт',
            ]),
            'director' => ScientificDirector::create([
                'login' => $login,
                'password' => $hashedPassword,
                'name' => $request->name ?? '',
                'patronum' => $request->patronum ?? '',
                'last_name' => $request->last_name ?? '',
                'date_of_birth' => $request->date_of_birth ?? date('Y-m-d'),
                'gender' => $request->gender ?? 1,
                'citizenship' => $request->citizenship ?? 'РФ',
                'academic_degree' => $request->academic_degree ?? '',
                'title_id' => $request->title_id ?: null,
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

        if (Auth::attempt($request->all())) {
            $userType = Auth::getUserType();
            match ($userType) {
                'admin' => app()->route->redirect('/admin/aspirants'),
                'director' => app()->route->redirect('/admin/dissertations'),
                'aspirant' => app()->route->redirect('/admin/publications'),
                default => app()->route->redirect('site.post'),
            };
            return '';
        }

        return (new View('site.post'))->render();
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/login');
        exit;
    }
}
