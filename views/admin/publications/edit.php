<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/publications/edit.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Редактировать публикацию</h1>
    <div class="nav-links">
        <a href="<?= app()->route->getUrl('/admin/publications') ?>">← Назад к публикациям</a>
    </div>
    <form method="POST" action="<?= app()->route->getUrl('/admin/publications/' . $publication->publication_id . '/update') ?>">
        <div class="form-group">
            <label>Название</label>
            <input type="text" name="title" value="<?= htmlspecialchars($publication->title) ?>" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Издание</label>
                <input type="text" name="edition" value="<?= htmlspecialchars($publication->edition) ?>" required>
            </div>
            <div class="form-group">
                <label>Дата публикации</label>
                <input type="date" name="publication" value="<?= $publication->publication ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Индекс РИНЦ/Scopus</label>
                <input type="text" name="index_rsci" value="<?= htmlspecialchars($publication->index_rsci) ?>" required>
            </div>
            <div class="form-group">
                <label>Команда</label>
                <select name="team_id" required>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?= $team->team_id ?>" <?= $publication->team_id == $team->team_id ? 'selected' : '' ?>>
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
