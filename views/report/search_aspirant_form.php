<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/admin/shared.css') ?>">
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/report/search_aspirant_form.css') ?>">

<div class="admin-container">
    <h1 class="admin-title">Поиск аспирантов по научному руководителю</h1>

    <form method="POST" action="<?= app()->route->getUrl('/report/search-aspirant') ?>" class="search-form">
        <input type="hidden" name="csrf_token" value="<?= \Src\Auth\Auth::generateCSRF() ?>">
        <div class="form-group">
            <label>
                Введите ФИО руководителя (минимум 2 символа)
                <input type="search" name="search" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Например: Иванов" minlength="2">
            </label>
        </div>
        <button class="btn" type="submit">Найти</button>
    </form>

    <?php if (!empty($searchQuery)): ?>
        <div class="search-results">
            <?php if (strlen($searchQuery) < 2): ?>
                <p class="empty-msg">Введите минимум 2 символа для поиска.</p>
            <?php elseif ($aspirants && count($aspirants) > 0): ?>
                <div class="grid-list">
                    <?php foreach ($aspirants as $asp): ?>
                    <div class="grid-card">
                        <h3><?= htmlspecialchars($asp->last_name . ' ' . $asp->name . ' ' . $asp->patronum) ?></h3>
                        <div class="card-row">
                            <span class="card-label">ID:</span>
                            <span class="card-value"><?= $asp->aspirant_id ?></span>
                        </div>
                        <div class="card-row">
                            <span class="card-label">Дата рождения:</span>
                            <span class="card-value"><?= $asp->date_of_birth ?></span>
                        </div>
                        <div class="card-row">
                            <span class="card-label">Гражданство:</span>
                            <span class="card-value"><?= htmlspecialchars($asp->citizenship) ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <p style="margin-top: 15px;"><strong>Найдено аспирантов:</strong> <?= count($aspirants) ?></p>
            <?php else: ?>
                <h2 class="results-title">Результаты поиска: "<?= htmlspecialchars($searchQuery) ?>"</h2>
                <p class="empty-msg">Аспиранты не найдены.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
