<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/shared.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Учёное звание #<?= $title->title_id ?></h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/titles') ?>">← Назад к званиям</a>
        <a class="btn btn-orange" href="<?= app()->route->getUrl('/admin/titles/' . $title->title_id . '/edit') ?>">Редактировать</a>
        <a class="btn btn-red" href="<?= app()->route->getUrl('/admin/titles/' . $title->title_id . '/delete') ?>" onclick="return confirm('Удалить?')">Удалить</a>
    </div>
    <div class="detail-row"><span class="detail-label">ID:</span> <?= $title->title_id ?></div>
    <div class="detail-row"><span class="detail-label">Звание:</span> <?= htmlspecialchars($title->academic_title) ?></div>

    <?php if ($title->scientificDirectors && count($title->scientificDirectors) > 0): ?>
        <h3 style="margin-top: 25px;">Руководители с этим званием</h3>
        <div class="grid-list">
            <?php foreach ($title->scientificDirectors as $director): ?>
            <div class="grid-card">
                <h3><?= htmlspecialchars($director->lasr_name . ' ' . $director->name . ' ' . $director->patronum) ?></h3>
                <div class="card-row">
                    <span class="card-label">ID:</span>
                    <span class="card-value"><?= $director->director_id ?></span>
                </div>
                <div class="card-row">
                    <span class="card-label">Учёная степень:</span>
                    <span class="card-value"><?= htmlspecialchars($director->academic_degree) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
