<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/statuses/view.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Редактировать статус</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/statuses') ?>">← Назад к статусам</a>
    </div>
    <form method="POST" action="<?= app()->route->getUrl('/admin/statuses/' . $status->status_id . '/update') ?>">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-group">
            <label>Статус</label>
            <input type="text" name="status" value="<?= htmlspecialchars($status->status) ?>" required>
        </div>
        <button class="btn" type="submit">Сохранить</button>
    </form>
</div>
