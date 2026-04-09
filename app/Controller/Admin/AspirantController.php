<?php

namespace Controller\Admin;

use Model\Aspirant;
use Src\View;
use Src\Request;
use Src\Validator\Validator;

class AspirantController
{
    public function index(): string
    {
        $aspirants = Aspirant::all();
        return (new View('admin.aspirants.index', ['aspirants' => $aspirants]))->render();
    }

    public function create(): string
    {
        return (new View('admin.aspirants.create'))->render();
    }

    public function store(Request $request): void
    {
        $validator = new Validator($request->all(), [
            'last_name' => ['required'],
            'name' => ['required'],
            'patronum' => ['required'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'numeric'],
            'citizenship' => ['required'],
            'identity_document' => ['required'],
            'login' => ['required', 'min:3'],
            'password' => ['required', 'min:6'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
            'date' => 'Поле :field должно быть датой в формате YYYY-MM-DD',
            'numeric' => 'Поле :field должно быть числом',
            'min' => 'Поле :field должно содержать минимум :min символов',
        ]);

        if ($validator->fails()) {
            $errors = array_merge(...array_values($validator->errors()));
            echo '<pre>' . htmlspecialchars(json_encode($errors, JSON_UNESCAPED_UNICODE)) . '</pre>';
            return;
        }

        Aspirant::create([
            'name' => $request->name,
            'patronum' => $request->patronum,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'citizenship' => $request->citizenship,
            'identity_document' => $request->{'identity_document'},
            'login' => $request->login,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
        ]);

        app()->route->redirect('/admin/aspirants');
    }

    public function view($id): string
    {
        $aspirant = Aspirant::with(['developmentTeams.director'])->find($id);
        return (new View('admin.aspirants.view', ['aspirant' => $aspirant]))->render();
    }

    public function edit($id): string
    {
        $aspirant = Aspirant::find($id);
        return (new View('admin.aspirants.edit', ['aspirant' => $aspirant]))->render();
    }

    public function update(Request $request, $id): void
    {
        $validator = new Validator($request->all(), [
            'last_name' => ['required'],
            'name' => ['required'],
            'patronum' => ['required'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'numeric'],
            'citizenship' => ['required'],
            'identity_document' => ['required'],
            'login' => ['required', 'min:3'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
            'date' => 'Поле :field должно быть датой в формате YYYY-MM-DD',
            'numeric' => 'Поле :field должно быть числом',
            'min' => 'Поле :field должно содержать минимум :min символов',
        ]);

        if ($validator->fails()) {
            $errors = array_merge(...array_values($validator->errors()));
            echo '<pre>' . htmlspecialchars(json_encode($errors, JSON_UNESCAPED_UNICODE)) . '</pre>';
            return;
        }

        $aspirant = Aspirant::find($id);
        $aspirant->update([
            'name' => $request->name,
            'patronum' => $request->patronum,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'citizenship' => $request->citizenship,
            'identity_document' => $request->{'identity_document'},
            'login' => $request->login,
        ]);

        app()->route->redirect('/admin/aspirants');
    }

    public function delete($id): void
    {
        $aspirant = Aspirant::find($id);
        $aspirant->delete();

        app()->route->redirect('/admin/aspirants');
    }
}
