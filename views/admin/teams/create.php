<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/teams/create.css') ?>">



<div class="admin-container">
    <h1 class="admin-title">Добавить команду</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/teams') ?>">← Назад к командам</a>
    </div>
    <form method="POST" action="<?= app()->route->getUrl('/admin/teams/store') ?>">
        <div class="form-group">
            <label>Научный руководитель</label>
            <select name="director_id" required>
                <option value="">— Выберите руководителя —</option>
                <?php foreach ($directors as $dir): ?>
                    <option value="<?= $dir->director_id ?>"><?= htmlspecialchars($dir->lasr_name . ' ' . $dir->name . ' ' . $dir->patronum) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Аспирант</label>
            <select name="aspirant_id" required>
                <option value="">— Выберите аспиранта —</option>
                <?php foreach ($aspirants as $asp): ?>
                    <option value="<?= $asp->aspirant_id ?>"><?= htmlspecialchars($asp->last_name . ' ' . $asp->name . ' ' . $asp->patronum) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="btn" type="submit">Создать</button>
    </form>
</div>
