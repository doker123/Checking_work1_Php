<?php

namespace Controller\Admin;

use Model\StatusDissertation;
use Src\View;
use Src\Request;
use Src\Validator\Validator;

class StatusDissertationController
{
    public function index(): string
    {
        $statuses = StatusDissertation::all();
        return (new View('admin.statuses.index', ['statuses' => $statuses]))->render();
    }

    public function create(): string
    {
        return (new View('admin.statuses.create'))->render();
    }

    public function store(Request $request): void
    {
        $validator = new Validator($request->all(), [
            'status' => ['required'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
        ]);

        if ($validator->fails()) {
            $errors = array_merge(...array_values($validator->errors()));
            echo '<pre>' . htmlspecialchars(json_encode($errors, JSON_UNESCAPED_UNICODE)) . '</pre>';
            return;
        }

        StatusDissertation::create([
            'status' => $request->status,
        ]);

        app()->route->redirect('/admin/statuses');
    }

    public function update($id, Request $request): void
    {
        $validator = new Validator($request->all(), [
            'status' => ['required'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
        ]);

        if ($validator->fails()) {
            $errors = array_merge(...array_values($validator->errors()));
            echo '<pre>' . htmlspecialchars(json_encode($errors, JSON_UNESCAPED_UNICODE)) . '</pre>';
            return;
        }

        $status = StatusDissertation::find($id);
        $status->update([
            'status' => $request->status,
        ]);

        app()->route->redirect('/admin/statuses');
    }

    public function delete($id): void
    {
        $status = StatusDissertation::find($id);
        $status->delete();

        app()->route->redirect('/admin/statuses');
    }
}
