<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/directors/edit.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Редактировать руководителя</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/directors') ?>">← Назад к руководителям</a>
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
    <form method="POST" action="<?= app()->route->getUrl('/admin/directors/' . $director->director_id . '/update') ?>">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-row">
            <div class="form-group">
                <label>Фамилия</label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($data['last_name'] ?? $director->lasr_name) ?>">
            </div>
            <div class="form-group">
                <label>Имя</label>
                <input type="text" name="name" value="<?= htmlspecialchars($data['name'] ?? $director->name) ?>">
            </div>
            <div class="form-group">
                <label>Отчество</label>
                <input type="text" name="patronum" value="<?= htmlspecialchars($data['patronum'] ?? $director->patronum) ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Дата рождения</label>
                <input type="date" name="date_of_birth" value="<?= htmlspecialchars($data['date_of_birth'] ?? $director->date_of_birth) ?>">
            </div>
            <div class="form-group">
                <label>Пол</label>
                <select name="gender">
                    <option value="1" <?= ($data['gender'] ?? $director->gender) == 1 ? 'selected' : '' ?>>Мужской</option>
                    <option value="0" <?= ($data['gender'] ?? $director->gender) == 0 ? 'selected' : '' ?>>Женский</option>
                </select>
            </div>
            <div class="form-group">
                <label>Гражданство</label>
                <input type="text" name="citizenship" value="<?= htmlspecialchars($data['citizenship'] ?? $director->citizenship) ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Учёная степень</label>
                <input type="text" name="academic_degree" value="<?= htmlspecialchars($data['academic_degree'] ?? $director->academic_degree) ?>">
            </div>
            <div class="form-group">
                <label>Учёное звание</label>
                <select name="title_id">
                    <option value="">— Без звания —</option>
                    <?php foreach ($titles as $title): ?>
                        <option value="<?= $title->title_id ?>" <?= ($data['title_id'] ?? $director->title_id) == $title->title_id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($title->academic_title) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Логин</label>
                <input type="text" name="login" value="<?= htmlspecialchars($data['login'] ?? $director->login) ?>">
            </div>
        </div>
        <button class="btn" type="submit">Сохранить</button>
    </form>
</div>
