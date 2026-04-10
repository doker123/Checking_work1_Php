<?php

namespace Controller\Admin;

use Model\ScientificDissertation;
use Model\StatusDissertation;
use Model\DevelopmentTeam;
use Src\View;
use Src\Request;
use Src\Validator\Validator;

class DissertationController
{
    public function index(): string
    {
        $dissertations = ScientificDissertation::with(['status', 'team'])->get();
        return (new View('admin.dissertations.index', ['dissertations' => $dissertations]))->render();
    }

    public function create(): string
    {
        $statuses = StatusDissertation::all();
        $teams = DevelopmentTeam::all();
        return (new View('admin.dissertations.create', ['statuses' => $statuses, 'teams' => $teams]))->render();
    }

    public function store(Request $request): void
    {
        $validator = new Validator($request->all(), [
            'theme' => ['required'],
            'approval_date' => ['required', 'date'],
            'status_id' => ['required', 'numeric'],
            'scientific_specialy' => ['required'],
            'team_id' => ['required', 'numeric'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
            'date' => 'Поле :field должно быть датой в формате YYYY-MM-DD',
            'numeric' => 'Поле :field должно быть числом',
        ]);

        if ($validator->fails()) {
            $errors = array_merge(...array_values($validator->errors()));
            echo '<pre>' . htmlspecialchars(json_encode($errors, JSON_UNESCAPED_UNICODE)) . '</pre>';
            return;
        }

        ScientificDissertation::create([
            'theme' => $request->theme,
            'approval_date' => $request->approval_date,
            'status_id' => $request->status_id,
            'scientific_specialy' => $request->scientific_specialy,
            'team_id' => $request->team_id,
        ]);

        app()->route->redirect('/admin/dissertations');
    }

    public function view($id): string
    {
        $dissertation = ScientificDissertation::with(['status', 'team.aspirant', 'team.director'])->find($id);
        return (new View('admin.dissertations.view', ['dissertation' => $dissertation]))->render();
    }

    public function edit($id): string
    {
        $dissertation = ScientificDissertation::find($id);
        $statuses = StatusDissertation::all();
        $teams = DevelopmentTeam::all();
        return (new View('admin.dissertations.edit', [
            'dissertation' => $dissertation,
            'statuses' => $statuses,
            'teams' => $teams
        ]))->render();
    }

    public function update($id, Request $request): void
    {
        $validator = new Validator($request->all(), [
            'theme' => ['required'],
            'approval_date' => ['required', 'date'],
            'status_id' => ['required', 'numeric'],
            'scientific_specialy' => ['required'],
            'team_id' => ['required', 'numeric'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
            'date' => 'Поле :field должно быть датой в формате YYYY-MM-DD',
            'numeric' => 'Поле :field должно быть числом',
        ]);

        if ($validator->fails()) {
            $errors = array_merge(...array_values($validator->errors()));
            echo '<pre>' . htmlspecialchars(json_encode($errors, JSON_UNESCAPED_UNICODE)) . '</pre>';
            return;
        }

        $dissertation = ScientificDissertation::find($id);
        $dissertation->update([
            'theme' => $request->theme,
            'approval_date' => $request->approval_date,
            'status_id' => $request->status_id,
            'scientific_specialy' => $request->scientific_specialy,
            'team_id' => $request->team_id,
        ]);

        app()->route->redirect('/admin/dissertations');
    }

    public function delete($id): void
    {
        $dissertation = ScientificDissertation::find($id);
        $dissertation->delete();

        app()->route->redirect('/admin/dissertations');
    }
}
