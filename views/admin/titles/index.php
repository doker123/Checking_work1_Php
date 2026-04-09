<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/shared.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Учёные звания</h1>
    <a class="btn" href="<?= app()->route->getUrl('/admin/titles/create') ?>">Добавить звание</a>
    <?php if (count($titles) === 0): ?>
        <p class="empty-msg">Званий пока нет.</p>
    <?php else: ?>
    <div class="grid-list">
        <?php foreach ($titles as $title): ?>
        <div class="grid-card">
            <h3><?= htmlspecialchars($title->academic_title) ?></h3>
            <div class="card-row">
                <span class="card-label">ID:</span>
                <span class="card-value"><?= $title->title_id ?></span>
            </div>
            <div class="card-actions">
                <a class="btn btn-blue" href="<?= app()->route->getUrl('/admin/titles/' . $title->title_id) ?>">Просмотр</a>
                <a class="btn btn-orange" href="<?= app()->route->getUrl('/admin/titles/' . $title->title_id . '/edit') ?>">Редактировать</a>
                <a class="btn btn-red" href="<?= app()->route->getUrl('/admin/titles/' . $title->title_id . '/delete') ?>" onclick="return confirm('Удалить?')">Удалить</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
