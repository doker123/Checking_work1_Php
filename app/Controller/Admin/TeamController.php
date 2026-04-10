<?php

namespace Controller\Admin;

use Model\DevelopmentTeam;
use Model\ScientificDirector;
use Model\Aspirant;
use Src\View;
use Src\Request;
use Src\Validator\Validator;

class TeamController
{
    public function index(): string
    {
        $teams = DevelopmentTeam::with(['director', 'aspirant'])->get();
        return (new View('admin.teams.index', ['teams' => $teams]))->render();
    }

    public function create(): string
    {
        $directors = ScientificDirector::all();
        $aspirants = Aspirant::all();
        return (new View('admin.teams.create', ['directors' => $directors, 'aspirants' => $aspirants]))->render();
    }

    public function store(Request $request): void
    {
        $validator = new Validator($request->all(), [
            'director_id' => ['required'],
            'aspirant_id' => ['required'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
        ]);

        if ($validator->fails()) {
            $errors = array_merge(...array_values($validator->errors()));
            echo '<pre>' . htmlspecialchars(json_encode($errors, JSON_UNESCAPED_UNICODE)) . '</pre>';
            return;
        }

        DevelopmentTeam::create([
            'director_id' => $request->director_id,
            'aspirant_id' => $request->aspirant_id,
        ]);

        app()->route->redirect('/admin/teams');
    }

    public function view($id): string
    {
        $team = DevelopmentTeam::with(['director', 'aspirant', 'dissertations', 'publications'])->find($id);
        return (new View('admin.teams.view', ['team' => $team]))->render();
    }

    public function edit($id): string
    {
        $team = DevelopmentTeam::find($id);
        $directors = ScientificDirector::all();
        $aspirants = Aspirant::all();
        return (new View('admin.teams.edit', [
            'team' => $team,
            'directors' => $directors,
            'aspirants' => $aspirants
        ]))->render();
    }

    public function update($id, Request $request): void
    {
        $validator = new Validator($request->all(), [
            'director_id' => ['required'],
            'aspirant_id' => ['required'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
        ]);

        if ($validator->fails()) {
            $errors = array_merge(...array_values($validator->errors()));
            echo '<pre>' . htmlspecialchars(json_encode($errors, JSON_UNESCAPED_UNICODE)) . '</pre>';
            return;
        }

        $team = DevelopmentTeam::find($id);
        $team->update([
            'director_id' => $request->director_id,
            'aspirant_id' => $request->aspirant_id,
        ]);

        app()->route->redirect('/admin/teams');
    }

    public function delete($id): void
    {
        $team = DevelopmentTeam::find($id);
        $team->delete();

        app()->route->redirect('/admin/teams');
    }
}
