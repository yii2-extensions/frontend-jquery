<?php

declare(strict_types=1);

/**
 * @var string $description Short description of the extension.
 * @var string $icon HTML content for the extension's icon.
 * @var string $name Name of the extension.
 * @var string $url URL to the extension's page.
 * @var \yii\web\View $this View component instance.
 */

use yii\bootstrap5\Html;
?>
<div class="card h-100 border-0 shadow-sm rounded-3 extension-card">
    <div class="card-body">
        <div class="d-flex align-items-center mb-3">
            <span class="extension-icon" aria-hidden="true"><?= $icon ?></span>
            <h3 class="h6 fw-bold mb-0 ms-2"><?= Html::encode($name) ?></h3>
        </div>
        <p class="text-body-secondary small mb-0">
            <?= Html::encode($description) ?>
        </p>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0">
        <?= Html::a(
            'Learn more &raquo;',
            $url,
            [
                'aria-label' => sprintf('Learn more about %s', $name),
                'class' => 'btn btn-sm btn-outline-secondary',
                'rel' => 'noopener noreferrer',
                'target' => '_blank',
            ],
        ) ?>
    </div>
</div>
