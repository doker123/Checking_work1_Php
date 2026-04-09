<?php

namespace Controller\Public;

use Model\ScientificDissertation;
use Model\ScientificPublication;
use Src\View;

class PublicationsController
{
    public function post():string
    {
        $dissertations = ScientificDissertation::with(['status', 'team.aspirant', 'team.director'])->get();
        $publications = ScientificPublication::with([ 'team.aspirant', 'team.director'])->get();
        return (new View('site.post',
            [
                'dissertations' => $dissertations,
                'publications' => $publications
            ]))->render();
    }

}