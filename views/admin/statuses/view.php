<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/shared.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Статус #<?= $status->status_id ?></h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/statuses') ?>">← Назад к статусам</a>
        <a class="btn btn-orange" href="<?= app()->route->getUrl('/admin/statuses/' . $status->status_id . '/edit') ?>">Редактировать</a>
        <a class="btn btn-red" href="<?= app()->route->getUrl('/admin/statuses/' . $status->status_id . '/delete') ?>" onclick="return confirm('Удалить?')">Удалить</a>
    </div>
    <div class="detail-row"><span class="detail-label">ID:</span> <?= $status->status_id ?></div>
    <div class="detail-row"><span class="detail-label">Статус:</span> <?= htmlspecialchars($status->status) ?></div>

    <?php if ($status->dissertations && count($status->dissertations) > 0): ?>
        <h3 style="margin-top: 25px;">Диссертации с этим статусом</h3>
        <div class="grid-list">
            <?php foreach ($status->dissertations as $diss): ?>
            <div class="grid-card">
                <h3><?= htmlspecialchars(mb_substr($diss->theme, 0, 50)) ?><?= mb_strlen($diss->theme) > 50 ? '...' : '' ?></h3>
                <div class="card-row">
                    <span class="card-label">Дата утверждения:</span>
                    <span class="card-value"><?= $diss->approval_date ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
