<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/site/login.css') ?>">

<div class="auth-container">
    <h2 class="auth-title">Авторизация</h2>

    <?php if (isset($message) && $message): ?>
        <div class="auth-message" style="background: #ffebee; color: #c62828;"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" class="auth-form">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <label>
            Логин
            <input type="text" name="login" placeholder="Введите логин">
        </label>
        <label>
            Пароль
            <input type="password" name="password" placeholder="Введите пароль">
        </label>
        <button class="auth-btn" type="submit">Войти</button>
    </form>
</div>
