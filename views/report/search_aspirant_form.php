<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/report/search_aspirant_result.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Поиск аспирантов по научному руководителю</h1>

    <form method="POST" action="<?= app()->route->getUrl('/report/search-aspirant') ?>">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-group">
            <label>
                Научный руководитель
                <select name="director_id" required>
                    <option value="">— Выберите руководителя —</option>
                    <?php foreach ($directors as $dir): ?>
                        <option value="<?= $dir->director_id ?>"><?= htmlspecialchars($dir->lasr_name . ' ' . $dir->name . ' ' . $dir->patronum) ?> (<?= htmlspecialchars($dir->academic_degree) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <button class="btn" type="submit">Найти</button>
    </form>
</div>
