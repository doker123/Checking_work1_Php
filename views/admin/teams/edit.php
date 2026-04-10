<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/teams/edit.css') ?>">


<div class="admin-container">
    <h1 class="admin-title">Редактировать команду</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/teams') ?>">← Назад к командам</a>
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
    <form method="POST" action="<?= app()->route->getUrl('/admin/teams/' . $team->team_id . '/update') ?>">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-group">
            <label>Научный руководитель</label>
            <select name="director_id">
                <option value="">— Выберите руководителя —</option>
                <?php foreach ($directors as $dir): ?>
                    <option value="<?= $dir->director_id ?>" <?= ($data['director_id'] ?? $team->director_id) == $dir->director_id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($dir->lasr_name . ' ' . $dir->name . ' ' . $dir->patronum) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Аспирант</label>
            <select name="aspirant_id">
                <option value="">— Выберите аспиранта —</option>
                <?php foreach ($aspirants as $asp): ?>
                    <option value="<?= $asp->aspirant_id ?>" <?= ($data['aspirant_id'] ?? $team->aspirant_id) == $asp->aspirant_id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($asp->last_name . ' ' . $asp->name . ' ' . $asp->patronum) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="btn" type="submit">Сохранить</button>
    </form>
</div>
