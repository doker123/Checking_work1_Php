<?php
namespace Controller\Admin;

use Model\ScientificPublication;
use Src\View;
use Src\Request;

class PublicationController
{
    public function index()
    {
        $publication = ScientificPublication::all();
        return(new View("admin/publications/index,",
            ['publications'=>$publication]))->
        render('admin/publications/index',
            ['publications'=>$publication]);
    }
    public function create():string
    {
        return(new View("admin/publications/create"))->
        render();
    }
    public function store():void
    {
        ScientificPublication::create([
            'title',
            'edition',
            'publication',
            'index_rsci',
            'team_id',
        ]);
        app()->route->redirect('/admin/publications');
    }
    public function view($id)
    {
        $publication = ScientificPublication::with('publication')->find($id);
        return(new View("admin/publications/view,",
            ['publications'=>$publication]))->
        render();
    }
    public function edit($id): string
    {
        $publication = ScientificPublication::with('publication')->find($id);
        return(new View("admin/publications/edit,",
            ['publications'=>$publication]))->
        render();
    }
    public function update($id)
    {
        $publications = ScientificPublication::find($id);
        $publications->update([
            'title',
            'edition',
            'publication',
            'index_rsci',
            'team_id',
        ]);
        app()->route->redirect('/admin/publications');
    }
    public function delete($id):void
    {
        $publications = ScientificPublication::find($id);
        $publications->delete();
    }
}
