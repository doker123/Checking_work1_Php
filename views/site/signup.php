<link rel="stylesheet" href="/Checking_work1_Php/public/css/site/signup.css">
<script defer src="/Checking_work1_Php/public/scripts/signup.js"></script>

<div class="auth-container">
    <h2 class="auth-title">Регистрация</h2>

    <?php if (isset($errors) && !empty($errors)): ?>
        <ul class="auth-errors">
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" class="auth-form" id="signupForm">
        <label>
            Роль
            <select name="user_type" id="userType" required>
                <option value="">— Выберите роль —</option>
                <option value="admin" <?= ($data['user_type'] ?? '') === 'admin' ? 'selected' : '' ?>>Администратор</option>
                <option value="director" <?= ($data['user_type'] ?? '') === 'director' ? 'selected' : '' ?>>Научный руководитель</option>
                <option value="aspirant" <?= ($data['user_type'] ?? '') === 'aspirant' ? 'selected' : '' ?>>Аспирант</option>
            </select>
        </label>

        <label>
            Логин
            <input type="text" name="login" required value="<?= htmlspecialchars($data['login'] ?? '') ?>">
        </label>

        <label>
            Пароль
            <input type="password" name="password" required>
        </label>

        <!-- Общие поля -->
        <div id="commonFields">
            <label>
                Имя
                <input type="text" name="name" value="<?= htmlspecialchars($data['name'] ?? '') ?>">
            </label>
        </div>

        <!-- Поля для руководителя -->
        <div id="directorFields" class="role-section">
            <h4 style="margin-top:0;">Данные руководителя</h4>
            <div class="form-row">
                <label>Фамилия
                    <input type="text" name="last_name" value="<?= htmlspecialchars($data['last_name'] ?? '') ?>">
                </label>
                <label>Отчество
                    <input type="text" name="patronum" value="<?= htmlspecialchars($data['patronum'] ?? '') ?>">
                </label>
            </div>
            <div class="form-row">
                <label>Дата рождения
                    <input type="date" name="date_of_birth" value="<?= $data['date_of_birth'] ?? '' ?>">
                </label>
                <label>Пол
                    <select name="gender">
                        <option value="1" <?= ($data['gender'] ?? '1') === '1' ? 'selected' : '' ?>>Мужской</option>
                        <option value="0" <?= ($data['gender'] ?? '') === '0' ? 'selected' : '' ?>>Женский</option>
                    </select>
                </label>
            </div>
            <label>Гражданство
                <input type="text" name="citizenship" value="<?= htmlspecialchars($data['citizenship'] ?? 'РФ') ?>">
            </label>
            <label>Учёная степень
                <input type="text" name="academic_degree" placeholder="Например: к.т.н." value="<?= htmlspecialchars($data['academic_degree'] ?? '') ?>">
            </label>
            <label>
                Учёное звание
                <select name="title_id">
                    <option value="">— Не выбрано —</option>
                    <?php foreach ($titles ?? [] as $title): ?>
                        <option value="<?= $title->title_id ?>" <?= ($data['title_id'] ?? '') == $title->title_id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($title->academic_title) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <!-- Поля для аспиранта -->
        <div id="aspirantFields" class="role-section">
            <h4 style="margin-top:0;">Данные аспиранта</h4>
            <div class="form-row">
                <label>Фамилия
                    <input type="text" name="last_name" value="<?= htmlspecialchars($data['last_name'] ?? '') ?>">
                </label>
                <label>Отчество
                    <input type="text" name="patronum" value="<?= htmlspecialchars($data['patronum'] ?? '') ?>">
                </label>
            </div>
            <div class="form-row">
                <label>Дата рождения
                    <input type="date" name="date_of_birth" value="<?= $data['date_of_birth'] ?? '' ?>">
                </label>
                <label>Пол
                    <select name="gender">
                        <option value="1" <?= ($data['gender'] ?? '1') === '1' ? 'selected' : '' ?>>Мужской</option>
                        <option value="0" <?= ($data['gender'] ?? '') === '0' ? 'selected' : '' ?>>Женский</option>
                    </select>
                </label>
            </div>
            <label>Гражданство
                <input type="text" name="citizenship" value="<?= htmlspecialchars($data['citizenship'] ?? 'РФ') ?>">
            </label>
            <label>Документ, удостоверяющий личность
                <input type="text" name="identity_document" value="<?= htmlspecialchars($data['identity_document'] ?? '') ?>">
            </label>
        </div>

        <button class="auth-btn" type="submit">Зарегистрироваться</button>
    </form>

    <div class="auth-link">
        <a href="<?= app()->route->getUrl('/login') ?>">Уже есть аккаунт? Войти</a>
    </div>
</div>

