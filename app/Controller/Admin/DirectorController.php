<?php

namespace Controller\Admin;

use Model\ScientificDirector;
use Model\AcademicTitle;
use Src\View;
use Src\Request;

class DirectorController
{
    public function index(): string
    {
        $directors = ScientificDirector::with('academicTitle')->get();
        return (new View('admin.directors.index', ['directors' => $directors]))->render();
    }

    public function create(): string
    {
        $titles = AcademicTitle::all();
        return (new View('admin.directors.create', ['titles' => $titles]))->render();
    }

    public function store(Request $request): void
    {
        ScientificDirector::create([
            'name' => $request->name,
            'patronum' => $request->patronum,
            'lasr_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'citizenship' => $request->citizenship,
            'academic_degree' => $request->academic_degree,
            'title_id' => $request->title_id,
            'login' => $request->login,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
        ]);

        app()->route->redirect('/admin/directors');
    }

    public function view($id): string
    {
        $director = ScientificDirector::with(['academicTitle', 'developmentTeams.aspirant'])->find($id);
        return (new View('admin.directors.view', ['director' => $director]))->render();
    }

    public function edit($id): string
    {
        $director = ScientificDirector::find($id);
        $titles = AcademicTitle::all();
        return (new View('admin.directors.edit', ['director' => $director, 'titles' => $titles]))->render();
    }

    public function update(Request $request, $id): void
    {
        $director = ScientificDirector::find($id);
        $director->update([
            'name' => $request->name,
            'patronum' => $request->patronum,
            'lasr_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'citizenship' => $request->citizenship,
            'academic_degree' => $request->academic_degree,
            'title_id' => $request->title_id,
            'login' => $request->login,
        ]);

        app()->route->redirect('/admin/directors');
    }

    public function delete($id): void
    {
        $director = ScientificDirector::find($id);
        $director->delete();

        app()->route->redirect('/admin/directors');
    }
}
