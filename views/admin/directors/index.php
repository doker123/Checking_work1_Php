<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/shared.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Научные руководители</h1>
    <a class="btn" href="<?= app()->route->getUrl('/admin/directors/create') ?>">Добавить руководителя</a>
    <?php if (count($directors) === 0): ?>
        <p class="empty-msg">Руководителей пока нет.</p>
    <?php else: ?>
    <div class="grid-list">
        <?php foreach ($directors as $dir): ?>
        <div class="grid-card">
            <h3><?= htmlspecialchars($dir->lasr_name . ' ' . $dir->name . ' ' . $dir->patronum) ?></h3>
            <div class="card-row">
                <span class="card-label">ID:</span>
                <span class="card-value"><?= $dir->director_id ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Учёная степень:</span>
                <span class="card-value"><?= htmlspecialchars($dir->academic_degree) ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Звание:</span>
                <span class="card-value"><?= $dir->academicTitle ? htmlspecialchars($dir->academicTitle->academic_title) : '—' ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Логин:</span>
                <span class="card-value"><?= htmlspecialchars($dir->login) ?></span>
            </div>
            <div class="card-actions">
                <a class="btn btn-blue" href="<?= app()->route->getUrl('/admin/directors/' . $dir->director_id) ?>">Просмотр</a>
                <a class="btn btn-orange" href="<?= app()->route->getUrl('/admin/directors/' . $dir->director_id . '/edit') ?>">Редактировать</a>
                <a class="btn btn-red" href="<?= app()->route->getUrl('/admin/directors/' . $dir->director_id . '/delete') ?>" onclick="return confirm('Удалить?')">Удалить</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
