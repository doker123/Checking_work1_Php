
<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/aspirants/create.css') ?>">
<div class="admin-container">
    <h1 class="admin-title">Добавить аспиранта</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/aspirants') ?>">← Назад к аспирантам</a>
    </div>
    <form method="POST" action="<?= app()->route->getUrl('/admin/aspirants/store') ?>">
        <div class="form-row">
            <div class="form-group">
                <label>Фамилия</label>
                <input type="text" name="last_name" required>
            </div>
            <div class="form-group">
                <label>Имя</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Отчество</label>
                <input type="text" name="patronum" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Дата рождения</label>
                <input type="date" name="date_of_birth" required>
            </div>
            <div class="form-group">
                <label>Пол</label>
                <select name="gender" required>
                    <option value="1">Мужской</option>
                    <option value="0">Женский</option>
                </select>
            </div>
            <div class="form-group">
                <label>Гражданство</label>
                <input type="text" name="citizenship" required>
            </div>
        </div>
        <div class="form-group">
            <label>Документ, удостоверяющий личность</label>
            <input type="text" name="identity_document" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Логин</label>
                <input type="text" name="login" required>
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" required>
            </div>
        </div>
        <button class="btn" type="submit">Создать</button>
    </form>
</div>
