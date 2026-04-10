<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/report/defend_form.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Отчёт по защитам за период</h1>

    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="error-messages">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= app()->route->getUrl('/report/defend') ?>">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-row">
            <div class="form-group">
                <label>Дата от</label>
                <input type="date" name="date_from" value="<?= htmlspecialchars($data['date_from'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Дата до</label>
                <input type="date" name="date_to" value="<?= htmlspecialchars($data['date_to'] ?? '') ?>">
            </div>
        </div>
        <button class="btn" type="submit">Сформировать отчёт</button>
    </form>
</div>
