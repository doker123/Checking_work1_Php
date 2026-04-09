<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/shared.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Отчёт по защитам: <?= $dateFrom ?> — <?= $dateTo ?></h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/report/defend') ?>">← Новый отчёт</a>
    </div>

    <div class="summary-card">
        <h3>Сводка по статусам</h3>
        <?php foreach ($byStatus as $info): ?>
        <div class="summary-row">
            <span><?= htmlspecialchars($info['status']) ?></span>
            <span><?= $info['count'] ?></span>
        </div>
        <?php endforeach; ?>
        <div class="total">Всего: <?= $total ?></div>
    </div>

    <?php if (count($dissertations) > 0): ?>
    <div class="grid-list">
        <?php foreach ($dissertations as $diss): ?>
        <div class="grid-card">
            <h3><?= htmlspecialchars(mb_substr($diss->theme, 0, 60)) ?><?= mb_strlen($diss->theme) > 60 ? '...' : '' ?></h3>
            <div class="card-row">
                <span class="card-label">ID:</span>
                <span class="card-value"><?= $diss->dissertations_id ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Статус:</span>
                <span class="card-value"><?= $diss->status ? htmlspecialchars($diss->status->status) : '—' ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Аспирант:</span>
                <span class="card-value"><?= $diss->team && $diss->team->aspirant ? htmlspecialchars($diss->team->aspirant->last_name . ' ' . $diss->team->aspirant->name) : '—' ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Руководитель:</span>
                <span class="card-value"><?= $diss->team && $diss->team->director ? htmlspecialchars($diss->team->director->lasr_name . ' ' . $diss->team->director->name) : '—' ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Дата утверждения:</span>
                <span class="card-value"><?= $diss->approval_date ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <p class="empty-msg">За указанный период диссертаций не найдено.</p>
    <?php endif; ?>
</div>
