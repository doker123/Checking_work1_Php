<?php

namespace Controller\Api;

use Model\ScientificPublication;
use Model\DevelopmentTeam;
use Src\Request;
use Src\View;
use Src\Validator\Validator;

class PublicationApiController
{
    public function index(): void
    {
        $publications = ScientificPublication::with(['team.aspirant', 'team.director'])->get();

        (new View())->toJSON($publications->toArray());
    }

    public function show($id): void
    {
        $publication = ScientificPublication::with(['team.aspirant', 'team.director'])->find($id);

        if (!$publication) {
            (new View())->toJSON(['error' => 'Публикация не найдена'], 404);
        }

        (new View())->toJSON($publication->toArray());
    }

    public function store(Request $request): void
    {
        $validator = new Validator($request->all(), [
            'title' => ['required'],
            'edition' => ['required'],
            'publication' => ['required'],
            'team_id' => ['required', 'numeric'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
            'numeric' => 'Поле :field должно быть числом',
        ]);

        if ($validator->fails()) {
            (new View())->toJSON([
                'error' => 'Ошибка валидации',
                'messages' => array_merge(...array_values($validator->errors())),
            ], 422);
        }

        $publication = ScientificPublication::create([
            'title' => $request->title,
            'edition' => $request->edition,
            'publication' => $request->publication,
            'index_rsci' => $request->index_rsci,
            'team_id' => $request->team_id,
        ]);

        $publication->load(['team.aspirant', 'team.director']);

        (new View())->toJSON($publication->toArray(), 201);
    }

    public function update($id, Request $request): void
    {
        $publication = ScientificPublication::find($id);

        if (!$publication) {
            (new View())->toJSON(['error' => 'Публикация не найдена'], 404);
        }

        $validator = new Validator($request->all(), [
            'title' => ['required'],
            'edition' => ['required'],
            'publication' => ['required'],
            'team_id' => ['required', 'numeric'],
        ], [
            'required' => 'Поле :field обязательно для заполнения',
            'numeric' => 'Поле :field должно быть числом',
        ]);

        if ($validator->fails()) {
            (new View())->toJSON([
                'error' => 'Ошибка валидации',
                'messages' => array_merge(...array_values($validator->errors())),
            ], 422);
        }

        $publication->update([
            'title' => $request->title,
            'edition' => $request->edition,
            'publication' => $request->publication,
            'index_rsci' => $request->index_rsci,
            'team_id' => $request->team_id,
        ]);

        $publication->load(['team.aspirant', 'team.director']);

        (new View())->toJSON($publication->toArray());
    }

    public function delete($id): void
    {
        $publication = ScientificPublication::find($id);

        if (!$publication) {
            (new View())->toJSON(['error' => 'Публикация не найдена'], 404);
        }

        $publication->delete();

        (new View())->toJSON(['message' => 'Публикация удалена']);
    }
}
