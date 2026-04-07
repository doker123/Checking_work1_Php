<?php
namespace Controller\Admin;

use Model\ScientificDissertation;
use Src\View;
use Src\Request;

class DissertationController
{
    public function index():string
    {
        $dissertation = ScientificDissertation::all();
        return (new View('admin.dissertation.index',
            ['dissertations'=>$dissertation]))->
        render('admin.dissertations.index',
            ['dissertations'=>$dissertation]);
    }
    public function create():string
    {
        return (new View('admin.dissertations.create',))->
        render();
    }
    public function store(Request $request):void
    {
        ScientificDissertation::create([
            'theme'=>$request->theme,
            'approval_date'=>$request->approval_date,
            'status_id'=>$request->status_id,
            'scientific_specialy'=>$request->scientific_specialy,
            'team_id'=>$request->team_id,
        ]);
        app()->route->redirect('/admin/dissertations');
    }
    public function view($id):string
    {
        $dissertation = ScientificDissertation::with('dissertation')->find($id);
        return (new View('admin.dissertations.view',
            ['dissertation'=>$dissertation]))->
        render();
    }
    public function edit($id):string
    {
        $dissertation = ScientificDissertation::find($id);
        return (new View('admin.dissertations.edit',
            ['dissertation'=>$dissertation]))->
        render();
    }
    public function update(Request $request,$id):void
    {
        $dissertation = ScientificDissertation::find($id);
        $dissertation->update([
            'theme'=>$request->theme,
            'approval_date'=>$request->approval_date,
            'status_id'=>$request->status_id,
            'scientific_specialy'=>$request->scientific_specialy,
            'team_id'=>$request->team_id,
        ]);
        app()->route->redirect('/admin/dissertations');
    }
    public function delete($id):void
    {
        $director = ScientificDissertation::find($id);
        $director->delete();
    }

}