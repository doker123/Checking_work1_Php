<?php

namespace Controller\Admin;

use Model\ScientificDissertation;
use Model\StatusDissertation;
use Model\DevelopmentTeam;
use Src\View;
use Src\Request;

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

    public function update(Request $request, $id): void
    {
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
