<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/shared.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Научные публикации</h1>
    <a class="btn" href="<?= app()->route->getUrl('/admin/publications/create') ?>">Добавить публикацию</a>
    <?php if (count($publications) === 0): ?>
        <p class="empty-msg">Публикаций пока нет.</p>
    <?php else: ?>
    <div class="grid-list">
        <?php foreach ($publications as $pub): ?>
        <div class="grid-card">
            <h3><?= htmlspecialchars(mb_substr($pub->title, 0, 60)) ?><?= mb_strlen($pub->title) > 60 ? '...' : '' ?></h3>
            <div class="card-row">
                <span class="card-label">ID:</span>
                <span class="card-value"><?= $pub->publication_id ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Издание:</span>
                <span class="card-value"><?= htmlspecialchars($pub->edition) ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Дата:</span>
                <span class="card-value"><?= $pub->publication ?></span>
            </div>
            <div class="card-row">
                <span class="card-label">Индекс РИНЦ/Scopus:</span>
                <span class="card-value"><?= htmlspecialchars($pub->index_rsci) ?></span>
            </div>
            <div class="card-actions">
                <a class="btn btn-blue" href="<?= app()->route->getUrl('/admin/publications/' . $pub->publication_id) ?>">Просмотр</a>
                <a class="btn btn-orange" href="<?= app()->route->getUrl('/admin/publications/' . $pub->publication_id . '/edit') ?>">Редактировать</a>
                <a class="btn btn-red" href="<?= app()->route->getUrl('/admin/publications/' . $pub->publication_id . '/delete') ?>" onclick="return confirm('Удалить?')">Удалить</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
