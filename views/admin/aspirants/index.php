<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/shared.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Аспиранты</h1>
    <a class="btn" href="<?= app()->route->getUrl('/admin/aspirants/create') ?>">Добавить аспиранта</a>
    <?php if (count($aspirants) === 0): ?>
        <p class="empty-msg">Аспирантов пока нет.</p>
    <?php else: ?>
    <div class="grid-list">
        <?php foreach ($aspirants as $asp): ?>
        <div class="grid-card">
            <h3><?= htmlspecialchars($asp->last_name . ' ' . $asp->name . ' ' . $asp->patronum) ?></h3>
            <div class="card-row">
                <span class="card-label">ID:</span>
                <span class="card-value"><?= $asp->aspirant_id ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Дата рождения:</span>
                <span class="card-value"><?= $asp->date_of_birth ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Пол:</span>
                <span class="card-value"><?= $asp->gender == 1 ? 'М' : 'Ж' ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Гражданство:</span>
                <span class="card-value"><?= htmlspecialchars($asp->citizenship) ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Логин:</span>
                <span class="card-value"><?= htmlspecialchars($asp->login) ?></span>
            </div>
            <div class="card-actions">
                <a class="btn btn-blue" href="<?= app()->route->getUrl('/admin/aspirants/' . $asp->aspirant_id) ?>">Просмотр</a>
                <a class="btn btn-orange" href="<?= app()->route->getUrl('/admin/aspirants/' . $asp->aspirant_id . '/edit') ?>">Редактировать</a>
                <a class="btn btn-red" href="<?= app()->route->getUrl('/admin/aspirants/' . $asp->aspirant_id . '/delete') ?>" onclick="return confirm('Удалить?')">Удалить</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
