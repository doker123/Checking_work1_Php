<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Аспирантура</title>
    <?php $url = app()->route; ?>
    <link rel="stylesheet" href="<?= $url->getUrl('/public/css/layouts/main.css') ?>">
</head>
<body>
<?php use Src\Auth\Auth; ?>
<header class="header">
    <nav class="header-nav">
        <a href="<?= app()->route->getUrl('/')?>">Главная</a>
        <?php if (Auth::check()): ?>
            <?php $userType = Auth::getUserType(); ?>
            <div class="nav-menu">
                <?php if ($userType === 'admin'): ?>
                    <a href="<?= app()->route->getUrl('/admin/aspirants') ?>">Аспиранты</a>
                    <a href="<?= app()->route->getUrl('/admin/directors') ?>">Руководители</a>
                    <a href="<?= app()->route->getUrl('/admin/teams') ?>">Команды</a>
                    <a href="<?= app()->route->getUrl('/admin/dissertations') ?>">Диссертации</a>
                    <a href="<?= app()->route->getUrl('/admin/publications') ?>">Публикации</a>
                    <a href="<?= app()->route->getUrl('/admin/titles') ?>">Звания</a>
                    <a href="<?= app()->route->getUrl('/admin/statuses') ?>">Статусы</a>
                <?php elseif ($userType === 'director'): ?>
                    <a href="<?= app()->route->getUrl('/admin/aspirants') ?>">Аспиранты</a>
                    <a href="<?= app()->route->getUrl('/admin/directors') ?>">Руководители</a>
                    <a href="<?= app()->route->getUrl('/admin/teams') ?>">Команды</a>
                    <a href="<?= app()->route->getUrl('/admin/dissertations') ?>">Диссертации</a>
                    <a href="<?= app()->route->getUrl('/admin/publications') ?>">Публикации</a>
                <?php elseif ($userType === 'aspirant'): ?>

                <?php endif; ?>
                <a href="<?= app()->route->getUrl('/report/search-aspirant') ?>">Поиск аспирантов</a>
                <a href="<?= app()->route->getUrl('/report/defend') ?>">Отчёты</a>
            </div>
        <?php endif; ?>
        <div class="nav-user">
            <?php if (!Auth::check()): ?>

            <div>
                <a href="<?= app()->route->getUrl('/report/search-aspirant') ?>">Поиск аспирантов</a>
                <a href="<?= app()->route->getUrl('/report/defend') ?>">Отчёты</a>
            </div>

            <div>
                <a class="enter" href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>
                <a class="enter" href="<?= app()->route->getUrl('/login') ?>">Вход</a>
            </div>
            <?php else: ?>
                <?php
                $roleNames = [
                    'admin' => 'Администратор',
                    'director' => 'Научный руководитель',
                    'aspirant' => 'Аспирант',
                ];
                $roleName = $roleNames[$userType] ?? 'Пользователь';
                $displayName = Auth::getDisplayName();
                ?>
                <span class="user-role"><?= $roleName ?>: <?= htmlspecialchars($displayName) ?></span>
                <a class="quit" href="<?= app()->route->getUrl('/logout') ?>">Выход</a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<div class="content">
    <?= $content ?? ''; ?>
</div>

</body>
</html>
