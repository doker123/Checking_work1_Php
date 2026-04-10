<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/publications/create.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Добавить публикацию</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/publications') ?>">← Назад к публикациям</a>
    </div>
    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="error-messages">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" action="<?= app()->route->getUrl('/admin/publications/store') ?>">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-group">
            <label>Название</label>
            <input type="text" name="title" value="<?= htmlspecialchars($data['title'] ?? '') ?>">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Издание</label>
                <input type="text" name="edition" value="<?= htmlspecialchars($data['edition'] ?? '') ?>" placeholder="Журнал/сборник">
            </div>
            <div class="form-group">
                <label>Дата публикации</label>
                <input type="date" name="publication" value="<?= htmlspecialchars($data['publication'] ?? '') ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Индекс РИНЦ/Scopus</label>
                <input type="text" name="index_rsci" value="<?= htmlspecialchars($data['index_rsci'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Команда</label>
                <select name="team_id">
                    <option value="">— Выберите команду —</option>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?= $team->team_id ?>" <?= ($data['team_id'] ?? '') === (string)$team->team_id ? 'selected' : '' ?>>
                            <?= $team->director ? htmlspecialchars($team->director->lasr_name) : '—' ?> /
                            <?= $team->aspirant ? htmlspecialchars($team->aspirant->last_name) : '—' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button class="btn" type="submit">Создать</button>
    </form>
</div>
