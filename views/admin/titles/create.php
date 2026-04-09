<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/titles/create.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Добавить учёное звание</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/titles') ?>">← Назад к званиям</a>
    </div>
    <form method="POST" action="<?= app()->route->getUrl('/admin/titles/store') ?>">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-group">
            <label>Учёное звание</label>
            <input type="text" name="academic_title" required placeholder="Например: Доцент, Профессор">
        </div>
        <button class="btn" type="submit">Создать</button>
    </form>
</div>
