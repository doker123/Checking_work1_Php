<?php

namespace Controller\Report;

use Model\ScientificDissertation;
use Model\ScientificDirector;
use Src\View;
use Src\Request;
use Src\Validator\Validator;
use MvcHelpers\AspirantUtils;

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
                'data' => $request->all(),
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
        $aspirants = collect();
        $searchQuery = '';
        return (new View('report.search_aspirant_form', [
            'directors' => $directors,
            'aspirants' => $aspirants,
            'searchQuery' => $searchQuery,
        ]))->render();
    }

    public function searchAspirant(Request $request): string
    {
        $directors = ScientificDirector::with('developmentTeams.aspirant')->get();
        $searchQuery = trim($request->search ?? '');

        $aspirants = collect();

        if (strlen($searchQuery) >= 2) {
            // Используем утилиту из пакета mvc-helpers
            $foundAspirants = AspirantUtils::searchAspirantsByDirectorName($directors->all(), $searchQuery);
            $aspirants = collect($foundAspirants);
        }

        return (new View('report.search_aspirant_form', [
            'directors' => $directors,
            'aspirants' => $aspirants,
            'searchQuery' => $searchQuery,
        ]))->render();
    }
}
