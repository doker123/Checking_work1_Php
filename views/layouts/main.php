<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Аспирантура</title>
    <link rel="stylesheet" href="/Checking_work1_Php/public/css/main.css">
</head>
<header class="header">
    <nav class="header-nav">
        <a class="home" href="<?= app()->route->getUrl('/hello') ?>">Главная</a>
        <div>
            <?php
            if (!app()->auth->check()):
                ?>
                <a class="enter" href="<?= app()->route->getUrl('/login') ?>">Вход</a>
                <a class="registration" href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>
            <?php
            else:
                ?>
                <a class="quit" href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth->user()->name ?>)</a>
            <?php
            endif;
            ?>
        </div>
    </nav>
</header>
<body>

<div class="content" >
    <?= $content ?? ''; ?>
</div>

</body>
</html>