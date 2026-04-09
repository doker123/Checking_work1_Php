<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/shared.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Команды</h1>
    <a class="btn" href="<?= app()->route->getUrl('/admin/teams/create') ?>">Добавить команду</a>
    <?php if (count($teams) === 0): ?>
        <p class="empty-msg">Команд пока нет.</p>
    <?php else: ?>
    <div class="grid-list">
        <?php foreach ($teams as $team): ?>
        <div class="grid-card">
            <h3>Команда #<?= $team->team_id ?></h3>
            <div class="card-row">
                <span class="card-label">Руководитель:</span>
                <span class="card-value"><?= $team->director ? htmlspecialchars($team->director->lasr_name . ' ' . $team->director->name) : '—' ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Аспирант:</span>
                <span class="card-value"><?= $team->aspirant ? htmlspecialchars($team->aspirant->last_name . ' ' . $team->aspirant->name) : '—' ?></span>
            </div>
            <div class="card-actions">
                <a class="btn btn-blue" href="<?= app()->route->getUrl('/admin/teams/' . $team->team_id) ?>">Просмотр</a>
                <a class="btn btn-orange" href="<?= app()->route->getUrl('/admin/teams/' . $team->team_id . '/edit') ?>">Редактировать</a>
                <a class="btn btn-red" href="<?= app()->route->getUrl('/admin/teams/' . $team->team_id . '/delete') ?>" onclick="return confirm('Удалить?')">Удалить</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
