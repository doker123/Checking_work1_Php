<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/shared.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Руководитель #<?= $director->director_id ?></h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/directors') ?>">← Назад к руководителям</a>
        <a class="btn btn-orange" href="<?= app()->route->getUrl('/admin/directors/' . $director->director_id . '/edit') ?>">Редактировать</a>
        <a class="btn btn-red" href="<?= app()->route->getUrl('/admin/directors/' . $director->director_id . '/delete') ?>" onclick="return confirm('Удалить?')">Удалить</a>
    </div>
    <div class="detail-row"><span class="detail-label">ID:</span> <?= $director->director_id ?></div>
    <div class="detail-row"><span class="detail-label">ФИО:</span> <?= htmlspecialchars($director->last_name . ' ' . $director->name . ' ' . $director->patronum) ?></div>
    <div class="detail-row"><span class="detail-label">Дата рождения:</span> <?= $director->date_of_birth ?></div>
    <div class="detail-row"><span class="detail-label">Пол:</span> <?= $director->gender == 1 ? 'Мужской' : 'Женский' ?></div>
    <div class="detail-row"><span class="detail-label">Гражданство:</span> <?= htmlspecialchars($director->citizenship) ?></div>
    <div class="detail-row"><span class="detail-label">Учёная степень:</span> <?= htmlspecialchars($director->academic_degree) ?></div>
    <div class="detail-row"><span class="detail-label">Учёное звание:</span> <?= $director->academicTitle ? htmlspecialchars($director->academicTitle->academic_title) : '—' ?></div>
    <div class="detail-row"><span class="detail-label">Логин:</span> <?= htmlspecialchars($director->login) ?></div>

    <?php if ($director->developmentTeams && count($director->developmentTeams) > 0): ?>
        <h3 style="margin-top: 25px;">Аспиранты</h3>
        <div class="grid-list">
            <?php foreach ($director->developmentTeams as $team): ?>
            <div class="grid-card">
                <h3>Команда #<?= $team->team_id ?></h3>
                <div class="card-row">
                    <span class="card-label">Аспирант:</span>
                    <span class="card-value"><?= $team->aspirant ? htmlspecialchars($team->aspirant->last_name . ' ' . $team->aspirant->name . ' ' . $team->aspirant->patronum) : '—' ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
