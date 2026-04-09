<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/dissertations/view.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Диссертация #<?= $dissertation->dissertations_id ?></h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/dissertations') ?>">← Назад к диссертациям</a>
        <a class="btn btn-orange" href="<?= app()->route->getUrl('/admin/dissertations/' . $dissertation->dissertations_id . '/edit') ?>">Редактировать</a>
        <a class="btn btn-red" href="<?= app()->route->getUrl('/admin/dissertations/' . $dissertation->dissertations_id . '/delete') ?>" onclick="return confirm('Удалить?')">Удалить</a>
    </div>
    <div class="detail-row"><span class="detail-label">ID:</span> <?= $dissertation->dissertations_id ?></div>
    <div class="detail-row"><span class="detail-label">Тема:</span> <?= htmlspecialchars($dissertation->theme) ?></div>
    <div class="detail-row"><span class="detail-label">Дата утверждения:</span> <?= $dissertation->approval_date ?></div>
    <div class="detail-row"><span class="detail-label">Статус:</span> <?= $dissertation->status ? htmlspecialchars($dissertation->status->status) : '—' ?></div>
    <div class="detail-row"><span class="detail-label">Специальность ВАК:</span> <?= htmlspecialchars($dissertation->scientific_specialy) ?></div>
    <div class="detail-row"><span class="detail-label">Команда:</span>
        <?php if ($dissertation->team): ?>
            <?= $dissertation->team->director ? htmlspecialchars($dissertation->team->director->lasr_name . ' ' . $dissertation->team->director->name) : '—' ?> /
            <?= $dissertation->team->aspirant ? htmlspecialchars($dissertation->team->aspirant->last_name . ' ' . $dissertation->team->aspirant->name) : '—' ?>
        <?php else: ?>—<?php endif; ?>
    </div>
</div>
