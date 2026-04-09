<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/shared.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Аспиранты руководителя</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/report/search-aspirant') ?>">← Новый поиск</a>
    </div>

    <?php if ($director): ?>
    <div class="director-info">
        <strong>Руководитель:</strong> <?= htmlspecialchars($director->lasr_name . ' ' . $director->name . ' ' . $director->patronum) ?><br>
        <strong>Учёная степень:</strong> <?= htmlspecialchars($director->academic_degree) ?><br>
        <strong>Учёное звание:</strong> <?= $director->academicTitle ? htmlspecialchars($director->academicTitle->academic_title) : '—' ?>
    </div>
    <?php endif; ?>

    <?php if ($aspirants && count($aspirants) > 0): ?>
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
                <span class="card-label">Гражданство:</span>
                <span class="card-value"><?= htmlspecialchars($asp->citizenship) ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <p style="margin-top: 15px;"><strong>Найдено аспирантов:</strong> <?= count($aspirants) ?></p>
    <?php else: ?>
        <p class="empty-msg">Аспиранты не найдены.</p>
    <?php endif; ?>
</div>
