<link rel="stylesheet" href="/Checking_work1_Php/public/css/login.css">


<div class="auth-container">
    <h2 class="auth-title">Авторизация</h2>
    <h3 class="auth-message <?= $message_type ?? ''; ?>"><?= $message ?? ''; ?></h3>
    <h3 class="user-great"><?= app()->auth->user()->name ?? ''; ?></h3>

    <?php if (!app()->auth->check()): ?>
        <form method="post" class="auth-form">
            <label>Логин
                <input type="text" name="login" required>
            </label>
            <label>Пароль
                <input type="password" name="password" required>
            </label>
            <button class="auth-btn">Войти</button>
        </form>
    <?php endif; ?>
</div>

