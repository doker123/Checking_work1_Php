<?php

namespace Controller\Admin;

use Model\AcademicTitle;
use Src\View;
use Src\Request;
use Src\Validator\Validator;

class AcademicTitleController
{
    public function index(): string
    {
        $titles = AcademicTitle::all();
        return (new View('admin.titles.index', ['titles' => $titles]))->render();
    }

    public function create(): string
    {
        return (new View('admin.titles.create'))->render();
    }

    public function store(Request $request)
    {
        $validator = new Validator($request->all(), [
            'academic_title' => ['required'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
        ]);

        if ($validator->fails()) {
            $errors = array_merge(...array_values($validator->errors()));
            return (new View('admin.titles.create', [
                'errors' => $errors,
                'data' => $request->all(),
            ]))->render();
        }

        AcademicTitle::create([
            'academic_title' => $request->academic_title,
        ]);

        app()->route->redirect('/admin/titles');
    }

    public function update($id, Request $request)
    {
        $validator = new Validator($request->all(), [
            'academic_title' => ['required'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
        ]);

        if ($validator->fails()) {
            $errors = array_merge(...array_values($validator->errors()));
            $title = AcademicTitle::find($id);
            return (new View('admin.titles.edit', [
                'errors' => $errors,
                'data' => $request->all(),
                'title' => $title,
            ]))->render();
        }

        $title = AcademicTitle::find($id);
        $title->update([
            'academic_title' => $request->academic_title,
        ]);

        app()->route->redirect('/admin/titles');
    }

    public function delete($id): void
    {
        $title = AcademicTitle::find($id);
        $title->delete();

        app()->route->redirect('/admin/titles');
    }
}
