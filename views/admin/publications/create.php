<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/publications/create.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Добавить публикацию</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/publications') ?>">← Назад к публикациям</a>
    </div>
    <form method="POST" action="<?= app()->route->getUrl('/admin/publications/store') ?>">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-group">
            <label>Название</label>
            <input type="text" name="title" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Издание</label>
                <input type="text" name="edition" required placeholder="Журнал/сборник">
            </div>
            <div class="form-group">
                <label>Дата публикации</label>
                <input type="date" name="publication" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Индекс РИНЦ/Scopus</label>
                <input type="text" name="index_rsci" required>
            </div>
            <div class="form-group">
                <label>Команда</label>
                <select name="team_id" required>
                    <option value="">— Выберите команду —</option>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?= $team->team_id ?>">
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
