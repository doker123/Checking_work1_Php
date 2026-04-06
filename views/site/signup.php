<link rel="stylesheet" href="/Checking_work1_Php/public/css/signup.css">

<div class="auth-container">
    <h2 class="auth-title">Регистрация нового пользователя</h2>
    <h3 class="auth-message <?= $message_type ?? ''; ?>"><?= $message ?? ''; ?></h3>

    <form method="post" class="auth-form">
        <label>Имя
            <input type="text" name="name" required>
        </label>
        <label>Логин
            <input type="text" name="login" required>
        </label>
        <label>Пароль
            <input type="password" name="password" required>
        </label>
        <button class="auth-btn">Зарегистрироваться</button>
    </form>
</div>
