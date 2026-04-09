<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/shared.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Статусы диссертаций</h1>
    <a class="btn" href="<?= app()->route->getUrl('/admin/statuses/create') ?>">Добавить статус</a>
    <?php if (count($statuses) === 0): ?>
        <p class="empty-msg">Статусов пока нет.</p>
    <?php else: ?>
    <div class="grid-list">
        <?php foreach ($statuses as $status): ?>
        <div class="grid-card">
            <h3><?= htmlspecialchars($status->status) ?></h3>
            <div class="card-row">
                <span class="card-label">ID:</span>
                <span class="card-value"><?= $status->status_id ?></span>
            </div>
            <div class="card-actions">
                <a class="btn btn-blue" href="<?= app()->route->getUrl('/admin/statuses/' . $status->status_id) ?>">Просмотр</a>
                <a class="btn btn-orange" href="<?= app()->route->getUrl('/admin/statuses/' . $status->status_id . '/edit') ?>">Редактировать</a>
                <a class="btn btn-red" href="<?= app()->route->getUrl('/admin/statuses/' . $status->status_id . '/delete') ?>" onclick="return confirm('Удалить?')">Удалить</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
