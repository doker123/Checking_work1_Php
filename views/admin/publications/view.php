<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/publications/view.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Публикация #<?= $publication->publication_id ?></h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/publications') ?>">← Назад к публикациям</a>
        <a class="btn btn-orange" href="<?= app()->route->getUrl('/admin/publications/' . $publication->publication_id . '/edit') ?>">Редактировать</a>
        <a class="btn btn-red" href="<?= app()->route->getUrl('/admin/publications/' . $publication->publication_id . '/delete') ?>" onclick="return confirm('Удалить?')">Удалить</a>
    </div>
    <div class="detail-row"><span class="detail-label">ID:</span> <?= $publication->publication_id ?></div>
    <div class="detail-row"><span class="detail-label">Название:</span> <?= htmlspecialchars($publication->title) ?></div>
    <div class="detail-row"><span class="detail-label">Издание:</span> <?= htmlspecialchars($publication->edition) ?></div>
    <div class="detail-row"><span class="detail-label">Дата публикации:</span> <?= $publication->publication ?></div>
    <div class="detail-row"><span class="detail-label">Индекс РИНЦ/Scopus:</span> <?= htmlspecialchars($publication->index_rsci) ?></div>
    <div class="detail-row"><span class="detail-label">Команда:</span>
        <?php if ($publication->team): ?>
            <?= $publication->team->director ? htmlspecialchars($publication->team->director->lasr_name . ' ' . $publication->team->director->name) : '—' ?> /
            <?= $publication->team->aspirant ? htmlspecialchars($publication->team->aspirant->last_name . ' ' . $publication->team->aspirant->name) : '—' ?>
        <?php else: ?>—<?php endif; ?>
    </div>
</div>
