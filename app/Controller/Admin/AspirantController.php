<?php

namespace Controller\Admin;

use Model\Aspirant;
use Src\View;
use Src\Request;
use Src\Validator\Validator;
use MvcHelpers\PasswordHasher;

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

    public function store(Request $request)
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
            return (new View('admin.aspirants.create', [
                'errors' => $errors,
                'data' => $request->all(),
            ]))->render();
        }

        $data = $request->all();
        $data['password'] = PasswordHasher::hash($data['password']);

        Aspirant::create($data);

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

    public function update($id, Request $request)
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
            $aspirant = Aspirant::find($id);
            return (new View('admin.aspirants.edit', [
                'aspirant' => $aspirant,
                'errors' => $errors,
                'data' => $request->all(),
            ]))->render();
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
