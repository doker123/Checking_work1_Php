<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/dissertations/create.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Добавить диссертацию</h1>
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
    <form method="POST" action="<?= app()->route->getUrl('/admin/dissertations/store') ?>">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-group">
            <label>Тема</label>
            <textarea name="theme" rows="3"><?= htmlspecialchars($data['theme'] ?? '') ?></textarea>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Дата утверждения</label>
                <input type="date" name="approval_date" value="<?= htmlspecialchars($data['approval_date'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Специальность ВАК</label>
                <input type="text" name="scientific_specialy" value="<?= htmlspecialchars($data['scientific_specialy'] ?? '') ?>" placeholder="Например: 5.2.1">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Статус</label>
                <select name="status_id">
                    <option value="">— Выберите статус —</option>
                    <?php foreach ($statuses as $st): ?>
                        <option value="<?= $st->status_id ?>" <?= ($data['status_id'] ?? '') === (string)$st->status_id ? 'selected' : '' ?>><?= htmlspecialchars($st->status) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Команда</label>
                <select name="team_id">
                    <option value="">— Выберите команду —</option>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?= $team->team_id ?>" <?= ($data['team_id'] ?? '') === (string)$team->team_id ? 'selected' : '' ?>>
                            <?= $team->director ? htmlspecialchars($team->director->lasr_name) : '—' ?> /
                            <?= $team->aspirant ? htmlspecialchars($team->aspirant->last_name) : '—' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button class="btn" type="submit">Создать</button>
    </form>
</div>
