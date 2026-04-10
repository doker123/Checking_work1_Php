<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/dissertations/edit.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Редактировать диссертацию</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/dissertations') ?>">← Назад к диссертациям</a>
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
    <form method="POST" action="<?= app()->route->getUrl('/admin/dissertations/' . $dissertation->dissertations_id . '/update') ?>">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-group">
            <label>Тема</label>
            <textarea name="theme" rows="3"><?= htmlspecialchars($data['theme'] ?? $dissertation->theme) ?></textarea>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Дата утверждения</label>
                <input type="date" name="approval_date" value="<?= htmlspecialchars($data['approval_date'] ?? $dissertation->approval_date) ?>">
            </div>
            <div class="form-group">
                <label>Специальность ВАК</label>
                <input type="text" name="scientific_specialy" value="<?= htmlspecialchars($data['scientific_specialy'] ?? $dissertation->scientific_specialy) ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Статус</label>
                <select name="status_id">
                    <?php foreach ($statuses as $st): ?>
                        <option value="<?= $st->status_id ?>" <?= ($data['status_id'] ?? $dissertation->status_id) == $st->status_id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($st->status) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Команда</label>
                <select name="team_id">
                    <?php foreach ($teams as $team): ?>
                        <option value="<?= $team->team_id ?>" <?= ($data['team_id'] ?? $dissertation->team_id) == $team->team_id ? 'selected' : '' ?>>
                            <?= $team->director ? htmlspecialchars($team->director->lasr_name) : '—' ?> /
                            <?= $team->aspirant ? htmlspecialchars($team->aspirant->last_name) : '—' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button class="btn" type="submit">Сохранить</button>
    </form>
</div>
