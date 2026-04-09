<?php

namespace Controller\Admin;

use Model\AcademicTitle;
use Src\View;
use Src\Request;

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

    public function store(Request $request): void
    {
        AcademicTitle::create([
            'academic_title' => $request->academic_title,
        ]);

        app()->route->redirect('/admin/titles');
    }

    public function view($id): string
    {
        $title = AcademicTitle::with('scientificDirectors')->find($id);
        return (new View('admin.titles.view', ['title' => $title]))->render();
    }

    public function edit($id): string
    {
        $title = AcademicTitle::find($id);
        return (new View('admin.titles.edit', ['title' => $title]))->render();
    }

    public function update(Request $request, $id): void
    {
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
