<?php

namespace Controller\Admin;

use Model\ScientificPublication;
use Model\DevelopmentTeam;
use Src\View;
use Src\Request;

class PublicationController
{
    public function index(): string
    {
        $publications = ScientificPublication::with(['team'])->get();
        return (new View('admin.publications.index', ['publications' => $publications]))->render();
    }

    public function create(): string
    {
        $teams = DevelopmentTeam::all();
        return (new View('admin.publications.create', ['teams' => $teams]))->render();
    }

    public function store(Request $request): void
    {
        ScientificPublication::create([
            'title' => $request->title,
            'edition' => $request->edition,
            'publication' => $request->publication,
            'index_rsci' => $request->index_rsci,
            'team_id' => $request->team_id,
        ]);

        app()->route->redirect('/admin/publications');
    }

    public function view($id): string
    {
        $publication = ScientificPublication::with(['team.aspirant', 'team.director'])->find($id);
        return (new View('admin.publications.view', ['publication' => $publication]))->render();
    }

    public function edit($id): string
    {
        $publication = ScientificPublication::find($id);
        $teams = DevelopmentTeam::all();
        return (new View('admin.publications.edit', ['publication' => $publication, 'teams' => $teams]))->render();
    }

    public function update(Request $request, $id): void
    {
        $publication = ScientificPublication::find($id);
        $publication->update([
            'title' => $request->title,
            'edition' => $request->edition,
            'publication' => $request->publication,
            'index_rsci' => $request->index_rsci,
            'team_id' => $request->team_id,
        ]);

        app()->route->redirect('/admin/publications');
    }

    public function delete($id): void
    {
        $publication = ScientificPublication::find($id);
        $publication->delete();

        app()->route->redirect('/admin/publications');
    }
}
