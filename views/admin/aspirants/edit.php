<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/aspirants/edit.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Редактировать аспиранта</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/aspirants') ?>">← Назад к аспирантам</a>
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

    <form method="POST" action="<?= app()->route->getUrl('/admin/aspirants/' . $aspirant->aspirant_id . '/update') ?>">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-row">
            <div class="form-group">
                <label>Фамилия</label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($data['last_name'] ?? $aspirant->last_name) ?>">
            </div>
            <div class="form-group">
                <label>Имя</label>
                <input type="text" name="name" value="<?= htmlspecialchars($data['name'] ?? $aspirant->name) ?>">
            </div>
            <div class="form-group">
                <label>Отчество</label>
                <input type="text" name="patronum" value="<?= htmlspecialchars($data['patronum'] ?? $aspirant->patronum) ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Дата рождения</label>
                <input type="date" name="date_of_birth" value="<?= htmlspecialchars($data['date_of_birth'] ?? $aspirant->date_of_birth) ?>">
            </div>
            <div class="form-group">
                <label>Пол</label>
                <select name="gender">
                    <option value="1" <?= ($data['gender'] ?? $aspirant->gender) == 1 ? 'selected' : '' ?>>Мужской</option>
                    <option value="0" <?= ($data['gender'] ?? $aspirant->gender) == 0 ? 'selected' : '' ?>>Женский</option>
                </select>
            </div>
            <div class="form-group">
                <label>Гражданство</label>
                <input type="text" name="citizenship" value="<?= htmlspecialchars($data['citizenship'] ?? $aspirant->citizenship) ?>">
            </div>
        </div>
        <div class="form-group">
            <label>Документ, удостоверяющий личность</label>
            <input type="text" name="identity_document" value="<?= htmlspecialchars($data['identity_document'] ?? $aspirant->{'identity_document'}) ?>">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Логин</label>
                <input type="text" name="login" value="<?= htmlspecialchars($data['login'] ?? $aspirant->login) ?>">
            </div>
        </div>
        <button class="btn" type="submit">Сохранить</button>
    </form>
</div>
