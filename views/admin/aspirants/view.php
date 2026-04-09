<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/shared.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Аспирант #<?= $aspirant->aspirant_id ?></h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/aspirants') ?>">← Назад к аспирантам</a>
        <a class="btn btn-orange" href="<?= app()->route->getUrl('/admin/aspirants/' . $aspirant->aspirant_id . '/edit') ?>">Редактировать</a>
        <a class="btn btn-red" href="<?= app()->route->getUrl('/admin/aspirants/' . $aspirant->aspirant_id . '/delete') ?>" onclick="return confirm('Удалить?')">Удалить</a>
    </div>
    <div class="detail-row"><span class="detail-label">ID:</span> <?= $aspirant->aspirant_id ?></div>
    <div class="detail-row"><span class="detail-label">ФИО:</span> <?= htmlspecialchars($aspirant->last_name . ' ' . $aspirant->name . ' ' . $aspirant->patronum) ?></div>
    <div class="detail-row"><span class="detail-label">Дата рождения:</span> <?= $aspirant->date_of_birth ?></div>
    <div class="detail-row"><span class="detail-label">Пол:</span> <?= $aspirant->gender == 1 ? 'Мужской' : 'Женский' ?></div>
    <div class="detail-row"><span class="detail-label">Гражданство:</span> <?= htmlspecialchars($aspirant->citizenship) ?></div>
    <div class="detail-row"><span class="detail-label">Документ:</span> <?= htmlspecialchars($aspirant->{'identity_document'}) ?></div>
    <div class="detail-row"><span class="detail-label">Логин:</span> <?= htmlspecialchars($aspirant->login) ?></div>

    <?php if ($aspirant->developmentTeams && count($aspirant->developmentTeams) > 0): ?>
        <h3 style="margin-top: 25px;">Команды</h3>
        <div class="grid-list">
            <?php foreach ($aspirant->developmentTeams as $team): ?>
            <div class="grid-card">
                <h3>Команда #<?= $team->team_id ?></h3>
                <div class="card-row">
                    <span class="card-label">Руководитель:</span>
                    <span class="card-value"><?= $team->director ? htmlspecialchars($team->director->last_name . ' ' . $team->director->name . ' ' . $team->director->patronum) : '—' ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
