<?php

namespace Controller\Admin;

use Model\StatusDissertation;
use Src\View;
use Src\Request;

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
        StatusDissertation::create([
            'status' => $request->status,
        ]);

        app()->route->redirect('/admin/statuses');
    }

    public function view($id): string
    {
        $status = StatusDissertation::with('dissertations')->find($id);
        return (new View('admin.statuses.view', ['status' => $status]))->render();
    }

    public function edit($id): string
    {
        $status = StatusDissertation::find($id);
        return (new View('admin.statuses.edit', ['status' => $status]))->render();
    }

    public function update(Request $request, $id): void
    {
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
