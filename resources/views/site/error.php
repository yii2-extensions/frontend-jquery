<?php

declare(strict_types=1);

/**
 * @var string $message Human-readable error message.
 * @var int $status HTTP status code of the error.
 * @var \yii\web\View $this View component instance.
 */

use yii\bootstrap5\Html;

$this->title = "Error {$status}";
?>
<div class="site-error d-flex align-items-center justify-content-center text-center">
    <div class="site-error-content mx-auto">
        <h1 class="display-1 fw-bold text-body-secondary mb-0"><?= Html::encode($status) ?></h1>
        <h2 class="display-6 fw-semibold mb-3"><?= Html::encode($message) ?></h2>
        <p class="text-body-secondary mb-4">
            The above error occurred while the Web server was processing your request.
            Please contact us if you think this is a server error. Thank you.
        </p>

        <?= Html::a(
            'Go to Homepage',
            Yii::$app->homeUrl,
            ['class' => 'btn btn-outline-primary btn-lg'],
        ) ?>

    </div>
</div>
