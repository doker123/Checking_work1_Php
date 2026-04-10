<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/statuses/create.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Добавить статус диссертации</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/statuses') ?>">← Назад к статусам</a>
    </div>
    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="error-messages">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" action="<?= app()->route->getUrl('/admin/statuses/store') ?>">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-group">
            <label>Статус</label>
            <input type="text" name="status" placeholder="Например: Пишется, Предзащита, Защищена" value="<?= htmlspecialchars($data['status'] ?? '') ?>">
        </div>
        <button class="btn" type="submit">Создать</button>
    </form>
</div>
