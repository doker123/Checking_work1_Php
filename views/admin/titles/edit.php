<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/titles/edit.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Редактировать учёное звание</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/titles') ?>">← Назад к званиям</a>
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
    <form method="POST" action="<?= app()->route->getUrl('/admin/titles/' . $title->title_id . '/update') ?>">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-group">
            <label>Учёное звание</label>
            <input type="text" name="academic_title" value="<?= htmlspecialchars($data['academic_title'] ?? $title->academic_title) ?>">
        </div>
        <button class="btn" type="submit">Сохранить</button>
    </form>
</div>
