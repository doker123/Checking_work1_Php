<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/shared.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Диссертации</h1>
    <a class="btn" href="<?= app()->route->getUrl('/admin/dissertations/create') ?>">Добавить диссертацию</a>
    <?php if (count($dissertations) === 0): ?>
        <p class="empty-msg">Диссертаций пока нет.</p>
    <?php else: ?>
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
                <span class="card-label">Специальность:</span>
                <span class="card-value"><?= htmlspecialchars($diss->scientific_specialy) ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Дата утверждения:</span>
                <span class="card-value"><?= $diss->approval_date ?></span>
            </div>
            <div class="card-actions">
                <a class="btn btn-blue" href="<?= app()->route->getUrl('/admin/dissertations/' . $diss->dissertations_id) ?>">Просмотр</a>
                <a class="btn btn-orange" href="<?= app()->route->getUrl('/admin/dissertations/' . $diss->dissertations_id . '/edit') ?>">Редактировать</a>
                <a class="btn btn-red" href="<?= app()->route->getUrl('/admin/dissertations/' . $diss->dissertations_id . '/delete') ?>" onclick="return confirm('Удалить?')">Удалить</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
