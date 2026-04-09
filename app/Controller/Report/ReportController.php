<?php

namespace Controller\Report;

use Model\ScientificDissertation;
use Model\ScientificDirector;
use Src\View;
use Src\Request;
use Src\Validator\Validator;

class ReportController
{
    public function defendReportForm(): string
    {
        return (new View('report.defend_form'))->render();
    }

    public function defendReport(Request $request): string
    {
        $validator = new Validator($request->all(), [
            'date_from' => ['required'],
            'date_to' => ['required'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
        ]);

        if ($validator->fails()) {
            $errors = array_merge(...array_values($validator->errors()));
            return (new View('report.defend_form', [
                'errors' => $errors,
            ]))->render();
        }

        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        $query = ScientificDissertation::with(['status', 'team.aspirant', 'team.director'])
            ->whereBetween('approval_date', [$dateFrom, $dateTo]);

        $dissertations = $query->get();

        $byStatus = $dissertations->groupBy('status_id')->map(function ($group) {
            return [
                'count' => $group->count(),
                'status' => $group->first()?->status?->status ?? 'Неизвестно'
            ];
        });

        $total = $dissertations->count();

        return (new View('report.defend_result', [
            'dissertations' => $dissertations,
            'byStatus' => $byStatus,
            'total' => $total,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]))->render();
    }

    public function searchAspirantForm(): string
    {
        $directors = ScientificDirector::all();
        return (new View('report.search_aspirant_form', ['directors' => $directors]))->render();
    }

    public function searchAspirant(Request $request): string
    {
        $validator = new Validator($request->all(), [
            'director_id' => ['required'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
        ]);

        if ($validator->fails()) {
            $errors = array_merge(...array_values($validator->errors()));
            $directors = ScientificDirector::all();
            return (new View('report.search_aspirant_form', [
                'directors' => $directors,
                'errors' => $errors,
            ]))->render();
        }

        $directorId = $request->director_id;

        $director = ScientificDirector::with([
            'developmentTeams.aspirant.developmentTeams'
        ])->find($directorId);

        $aspirants = collect();
        if ($director) {
            foreach ($director->developmentTeams as $team) {
                $aspirants->push($team->aspirant);
            }
        }

        return (new View('report.search_aspirant_result', [
            'director' => $director,
            'aspirants' => $aspirants,
        ]))->render();
    }
}
