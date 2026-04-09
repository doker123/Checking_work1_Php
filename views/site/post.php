<h1>Научные посты наших учёных</h1>
<h2>Список диссертаций</h2>
<?php $url = app()->route; ?>
<link rel="stylesheet" href="<?= $url->getUrl('/public/css/site/post.css') ?>">
<?php if ($dissertations->isEmpty()): ?>
    <p class="empty-message">Диссертаций пока нет.</p>
<?php else: ?>
    <div class="dissertations-grid">
        <?php foreach ($dissertations as $d): ?>
            <div class="dissertation-card">
                <h3><?= htmlspecialchars($d->theme ?? 'Без темы') ?></h3>
                <div class="card-row">
                    <span class="card-label">Аспирант:</span>
                    <span class="card-value">
                    <?php
                    $aspirant = $d->team?->aspirant;
                    echo $aspirant
                            ? htmlspecialchars(trim("{$aspirant->last_name} {$aspirant->name} {$aspirant->patronum}"))
                            : '—';
                    ?>
                </span>
                </div>
                <div class="card-row">
                    <span class="card-label">Руководитель:</span>
                    <span class="card-value">
                    <?php
                    $director = $d->team?->director;
                    echo $director
                            ? htmlspecialchars(trim("{$director->last_name} {$director->name} {$director->patronum}"))
                            : '—';
                    ?>
                </span>
                </div>
                <div class="card-row">
                    <span class="card-label">Дата утверждения:</span>
                    <span class="card-value"><?= htmlspecialchars($d->approval_date ?? '—') ?></span>
                </div>
                <div class="card-row">
                    <span class="card-label">Статус:</span>
                    <span class="card-value">
                    <span class="status-badge"><?= htmlspecialchars($d->status_text ?? '—') ?></span>
                </span>
                </div>
                <div class="card-row">
                    <span class="card-label">Специальность:</span>
                    <span class="card-value"><?= htmlspecialchars($d->scientific_specialy ?? '—') ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<h2>Список публикаций</h2>

<?php if ($publications->isEmpty()): ?>
    <p class="empty-message">Публикаций пока нет.</p>
<?php else: ?>
    <div class="publications-grid">
        <?php foreach ($publications as $p): ?>
            <div class="publication-card">
                <h3><?= htmlspecialchars($p->title ?? 'Без названия') ?></h3>
                <div class="card-row">
                    <span class="card-label">Издание:</span>
                    <span class="card-value"><?= htmlspecialchars($p->edition_type ?? '—') ?></span>
                </div>
                <div class="card-row">
                    <span class="card-label">Публикация:</span>
                    <span class="card-value"><?= htmlspecialchars($p->publication ?? '—') ?></span>
                </div>
                <div class="card-row">
                    <span class="card-label">Аспирант:</span>
                    <span class="card-value">
                    <?php
                    $aspirant = $p->team?->aspirant;
                    echo $aspirant
                            ? htmlspecialchars(trim("{$aspirant->last_name} {$aspirant->name} {$aspirant->patronum}"))
                            : '—';
                    ?>
                </span>
                </div>
                <div class="card-row">
                    <span class="card-label">Руководитель:</span>
                    <span class="card-value">
                    <?php
                    $director = $p->team?->director;
                    echo $director
                            ? htmlspecialchars(trim("{$director->last_name} {$director->name} {$director->patronum}"))
                            : '—';
                    ?>
                </span>
                </div>
                <div class="card-row">
                    <span class="card-label">Индексация:</span>
                    <span class="card-value">
                    <span class="index-badge"><?= htmlspecialchars($p->indexing ?? '—') ?></span>
                </span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
