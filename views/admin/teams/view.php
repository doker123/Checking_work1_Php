<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/shared.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Команда #<?= $team->team_id ?></h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/teams') ?>">← Назад к командам</a>
        <a class="btn btn-orange" href="<?= app()->route->getUrl('/admin/teams/' . $team->team_id . '/edit') ?>">Редактировать</a>
        <a class="btn btn-red" href="<?= app()->route->getUrl('/admin/teams/' . $team->team_id . '/delete') ?>" onclick="return confirm('Удалить?')">Удалить</a>
    </div>
    <div class="detail-row"><span class="detail-label">ID:</span> <?= $team->team_id ?></div>
    <div class="detail-row"><span class="detail-label">Руководитель:</span> <?= $team->director ? htmlspecialchars($team->director->lasr_name . ' ' . $team->director->name . ' ' . $team->director->patronum) : '—' ?></div>
    <div class="detail-row"><span class="detail-label">Аспирант:</span> <?= $team->aspirant ? htmlspecialchars($team->aspirant->last_name . ' ' . $team->aspirant->name . ' ' . $team->aspirant->patronum) : '—' ?></div>

    <?php if ($team->dissertations && count($team->dissertations) > 0): ?>
        <h3 style="margin-top: 25px;">Диссертации</h3>
        <div class="grid-list">
            <?php foreach ($team->dissertations as $diss): ?>
            <div class="grid-card">
                <h3><?= htmlspecialchars(mb_substr($diss->theme, 0, 50)) ?><?= mb_strlen($diss->theme) > 50 ? '...' : '' ?></h3>
                <div class="card-row">
                    <span class="card-label">Статус:</span>
                    <span class="card-value"><?= $diss->status ? htmlspecialchars($diss->status->status) : '—' ?></span>
                </div>
                <div class="card-row">
                    <span class="card-label">Дата утверждения:</span>
                    <span class="card-value"><?= $diss->approval_date ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($team->publications && count($team->publications) > 0): ?>
        <h3 style="margin-top: 25px;">Публикации</h3>
        <div class="grid-list">
            <?php foreach ($team->publications as $pub): ?>
            <div class="grid-card">
                <h3><?= htmlspecialchars(mb_substr($pub->title, 0, 50)) ?><?= mb_strlen($pub->title) > 50 ? '...' : '' ?></h3>
                <div class="card-row">
                    <span class="card-label">Издание:</span>
                    <span class="card-value"><?= htmlspecialchars($pub->edition) ?></span>
                </div>
                <div class="card-row">
                    <span class="card-label">Дата:</span>
                    <span class="card-value"><?= $pub->publication ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
