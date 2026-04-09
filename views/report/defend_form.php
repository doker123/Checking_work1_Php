<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/report/defend_form.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Отчёт по защитам за период</h1>
    <form method="POST" action="<?= app()->route->getUrl('/report/defend') ?>">
        <div class="form-row">
            <div class="form-group">
                <label>Дата от</label>
                <input type="date" name="date_from" required>
            </div>
            <div class="form-group">
                <label>Дата до</label>
                <input type="date" name="date_to" required>
            </div>
        </div>
        <button class="btn" type="submit">Сформировать отчёт</button>
    </form>
</div>
