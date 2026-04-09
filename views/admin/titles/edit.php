<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/titles/edit.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Редактировать учёное звание</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/titles') ?>">← Назад к званиям</a>
    </div>
    <form method="POST" action="<?= app()->route->getUrl('/admin/titles/' . $title->title_id . '/update') ?>">
        <div class="form-group">
            <label>Учёное звание</label>
            <input type="text" name="academic_title" value="<?= htmlspecialchars($title->academic_title) ?>" required>
        </div>
        <button class="btn" type="submit">Сохранить</button>
    </form>
</div>
