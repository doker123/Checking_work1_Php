<?php
namespace Controller\Admin;

use Model\Aspirant;
use Src\View;
use Src\Request;

class AspirantController
{
    public function index():string
    {
        $aspirant = Aspirant::all();
        return ( new View('admin.$aspirants.index',
            ['aspirants' => $aspirant]))->
        render('admin.aspirant.index',
            ['aspirants' => $aspirant]);
    }
    public function create():string
    {
        return (new View('admin.$aspirants.create'))->
        render();
    }
    public function store(Request $request):void
    {
        Aspirant::create([
            'name'=>$request ->name,
            'patronum'=>$request->patronum,
            'last_name'=>$request->last_name,
            'date_of_birth'=>$request->date_of_birth,
            'gender'=>$request->gender,
            'citizenship'=>$request->citizenship,
            'identity document'=>$request->indentity_document,
            'login'=>$request->login,
            'password'=>$request->password,
        ]);
        app()->route->redirect('/admin/aspirants');
    }
    public function view($id):string
    {
        $aspirant= Aspirant::with([
            'scientificDirectors',
            'dissertations',
            'publications'])->find($id);
        return (new View('admin.aspirants.view',
            ['aspirant' => $aspirant]))
            ->render();
    }
    public function edit($id):string
    {
        $aspirant= Aspirant::find($id);
        return (new View('admin.aspirants.edit',
            ['aspirant' => $aspirant]))->render();
    }
    public function update(Request $request,$id):void
    {
        $aspirant = Aspirant::find($id);
        $aspirant->update([
            'name'=>$request ->name,
            'patronum'=>$request->patronum,
            'last_name'=>$request->last_name,
            'date_of_birth'=>$request->date_of_birth,
            'gender'=>$request->gender,
            'citizenship'=>$request->citizenship,
            'identity document'=>$request->indentity_document,
            'login'=>$request->login,
        ]);
        app()->route->redirect('/admin/aspirants');
    }
    public function delete($id):void
    {
        $aspirant = Aspirant::find($id);
        $aspirant->delete();

        app()->route->redirect('/admin/aspirants');
    }
}