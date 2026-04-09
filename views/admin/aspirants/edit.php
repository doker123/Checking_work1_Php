<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/aspirants/edit.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Редактировать аспиранта</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/aspirants') ?>">← Назад к аспирантам</a>
    </div>
    <form method="POST" action="<?= app()->route->getUrl('/admin/aspirants/' . $aspirant->aspirant_id . '/update') ?>">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-row">
            <div class="form-group">
                <label>Фамилия</label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($aspirant->last_name) ?>" required>
            </div>
            <div class="form-group">
                <label>Имя</label>
                <input type="text" name="name" value="<?= htmlspecialchars($aspirant->name) ?>" required>
            </div>
            <div class="form-group">
                <label>Отчество</label>
                <input type="text" name="patronum" value="<?= htmlspecialchars($aspirant->patronum) ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Дата рождения</label>
                <input type="date" name="date_of_birth" value="<?= $aspirant->date_of_birth ?>" required>
            </div>
            <div class="form-group">
                <label>Пол</label>
                <select name="gender" required>
                    <option value="1" <?= $aspirant->gender == 1 ? 'selected' : '' ?>>Мужской</option>
                    <option value="0" <?= $aspirant->gender == 0 ? 'selected' : '' ?>>Женский</option>
                </select>
            </div>
            <div class="form-group">
                <label>Гражданство</label>
                <input type="text" name="citizenship" value="<?= htmlspecialchars($aspirant->citizenship) ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label>Документ, удостоверяющий личность</label>
            <input type="text" name="identity_document" value="<?= htmlspecialchars($aspirant->{'identity_document'}) ?>" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Логин</label>
                <input type="text" name="login" value="<?= htmlspecialchars($aspirant->login) ?>" required>
            </div>
        </div>
        <button class="btn" type="submit">Сохранить</button>
    </form>
</div>
