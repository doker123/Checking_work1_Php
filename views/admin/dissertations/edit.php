<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/dissertations/edit.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Редактировать диссертацию</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/dissertations') ?>">← Назад к диссертациям</a>
    </div>
    <form method="POST" action="<?= app()->route->getUrl('/admin/dissertations/' . $dissertation->dissertations_id . '/update') ?>">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-group">
            <label>Тема</label>
            <textarea name="theme" rows="3" required><?= htmlspecialchars($dissertation->theme) ?></textarea>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Дата утверждения</label>
                <input type="date" name="approval_date" value="<?= $dissertation->approval_date ?>" required>
            </div>
            <div class="form-group">
                <label>Специальность ВАК</label>
                <input type="text" name="scientific_specialy" value="<?= htmlspecialchars($dissertation->scientific_specialy) ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Статус</label>
                <select name="status_id" required>
                    <?php foreach ($statuses as $st): ?>
                        <option value="<?= $st->status_id ?>" <?= $dissertation->status_id == $st->status_id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($st->status) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Команда</label>
                <select name="team_id" required>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?= $team->team_id ?>" <?= $dissertation->team_id == $team->team_id ? 'selected' : '' ?>>
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
