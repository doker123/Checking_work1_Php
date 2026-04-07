<?php

namespace Controller\Admin;

use Model\ScientificDirector;
use Src\View;
use Src\Request;

class DirectorController
{
    public function index(): string
    {
        $director = ScientificDirector::all();
        return (new View("admin/directors/index",
            ["directors" => $director]))->
        render('admin/director/index',
            ["directors" => $director]);
    }

    public function create(): string
    {
        return (new View("admin/directors/create"))->
        render();
    }

    public function store(Request $request): void
    {
        ScientificDirector::create([
            'name' => $request->name,
            'patronum' => $request->patronum,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'citizenship' => $request->citizenship,
            'academic degree' => $request->academic_degree,
            'title_id' => $request->title_id,
            'login' => $request->login,
            'password' => $request->password,
        ]);

        app()->route->redirect('/admin/directors');
    }

    public function view($id): string
    {
        $director = ScientificDirector::with([
            'scientificDirectors',])->find($id);
        return (new View('admin.directors.view',
            ['director' => $director]))
            ->render();
    }

    public function edit($id): string
    {
        $director = ScientificDirector::find($id);
        return (new View("admin/director/edit",
            ['director' => $director]))->
        render();
    }
    public function update($id, Request $request): void
    {
        $director = ScientificDirector::find($id);
        $director->update([
            'name'=>$request ->name,
            'patronum'=>$request->patronum,
            'last_name'=>$request->last_name,
            'date_of_birth'=>$request->date_of_birth,
            'gender'=>$request->gender,
            'citizenship'=>$request->citizenship,
            'title_id' => $request->title_id,
            'login'=>$request->login,
        ]);
        app()->route->redirect('/admin/directors');
    }
    public function delete($id):void
    {
        $director = ScientificDirector::find($id);
        $director->delete();

        app()->route->redirect('/admin/directors');
    }
}