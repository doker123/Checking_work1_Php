<?php

namespace Controller\Api;

use Model\ScientificDissertation;
use Model\StatusDissertation;
use Model\DevelopmentTeam;
use Src\Request;
use Src\View;
use Src\Validator\Validator;

class DissertationApiController
{
    public function index(): void
    {
        $dissertations = ScientificDissertation::with(['status', 'team.aspirant', 'team.director'])->get();

        (new View())->toJSON($dissertations->toArray());
    }

    public function show($id): void
    {
        $dissertation = ScientificDissertation::with(['status', 'team.aspirant', 'team.director'])->find($id);

        if (!$dissertation) {
            (new View())->toJSON(['error' => 'Диссертация не найдена'], 404);
        }

        (new View())->toJSON($dissertation->toArray());
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
            (new View())->toJSON([
                'error' => 'Ошибка валидации',
                'messages' => array_merge(...array_values($validator->errors())),
            ], 422);
        }

        $dissertation = ScientificDissertation::create([
            'theme' => $request->theme,
            'approval_date' => $request->approval_date,
            'status_id' => $request->status_id,
            'scientific_specialy' => $request->scientific_specialy,
            'team_id' => $request->team_id,
        ]);

        $dissertation->load(['status', 'team.aspirant', 'team.director']);

        (new View())->toJSON($dissertation->toArray(), 201);
    }

    public function update($id, Request $request): void
    {
        $dissertation = ScientificDissertation::find($id);

        if (!$dissertation) {
            (new View())->toJSON(['error' => 'Диссертация не найдена'], 404);
        }

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
            (new View())->toJSON([
                'error' => 'Ошибка валидации',
                'messages' => array_merge(...array_values($validator->errors())),
            ], 422);
        }

        $dissertation->update([
            'theme' => $request->theme,
            'approval_date' => $request->approval_date,
            'status_id' => $request->status_id,
            'scientific_specialy' => $request->scientific_specialy,
            'team_id' => $request->team_id,
        ]);

        $dissertation->load(['status', 'team.aspirant', 'team.director']);

        (new View())->toJSON($dissertation->toArray());
    }

    public function delete($id): void
    {
        $dissertation = ScientificDissertation::find($id);

        if (!$dissertation) {
            (new View())->toJSON(['error' => 'Диссертация не найдена'], 404);
        }

        $dissertation->delete();

        (new View())->toJSON(['message' => 'Диссертация удалена']);
    }
}
