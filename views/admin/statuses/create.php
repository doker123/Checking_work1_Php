<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/statuses/create.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Добавить статус диссертации</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/statuses') ?>">← Назад к статусам</a>
    </div>
    <form method="POST" action="<?= app()->route->getUrl('/admin/statuses/store') ?>">
        <div class="form-group">
            <label>Статус</label>
            <input type="text" name="status" required placeholder="Например: Пишется, Предзащита, Защищена">
        </div>
        <button class="btn" type="submit">Создать</button>
    </form>
</div>
