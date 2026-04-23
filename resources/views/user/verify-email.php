<?php

declare(strict_types=1);

/**
 * @var app\models\VerifyEmailForm $model Verify form model instance.
 * @var string $token Verification token.
 * @var \yii\web\View $this View component instance.
 */

use yii\bootstrap5\Html;

$this->title = 'Confirm email';
$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = 'Confirm your email address to complete registration.';
?>
<div class="site-verify-email d-flex align-items-center justify-content-center py-5">
    <div class="card border-0 overflow-hidden login-split-card">
        <div class="row g-0">
            <!-- Brand panel -->
            <div class="col-md-5 d-none d-md-flex login-brand-panel text-white">
                <div class="d-flex flex-column justify-content-between p-4 p-lg-5 w-100">
                    <div>
                        <?= Html::img(
                            Yii::getAlias('@web/images/yii3_full_white_for_dark.svg'),
                            [
                                'alt' => 'Yii Framework',
                                'class' => 'mb-4',
                                'height' => 40,
                            ],
                        ) ?>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-3 login-brand-title">
                            Almost<br>There
                        </h2>
                        <p class="opacity-75 mb-0 login-brand-text">
                            Click the button below to confirm your email address and activate your account.
                        </p>
                    </div>
                </div>
            </div>
            <!-- Form panel -->
            <div class="col-md-7">
                <div class="p-4 p-lg-5">
                    <div class="text-center mb-4">
                        <div class="d-md-none mb-3">
                            <?= Html::img(
                                Yii::getAlias('@web/images/yii3_full_black_for_light.svg'),
                                [
                                    'alt' => 'Yii Framework',
                                    'class' => 'login-mobile-logo',
                                    'height' => 36,
                                ],
                            ) ?>
                        </div>
                        <h1 class="h3 fw-bold mb-1"><?= Html::encode($this->title) ?></h1>
                        <p class="text-body-secondary small">
                            Click the button below to verify your email address
                        </p>
                    </div>

                    <?= Html::beginForm(['user/confirm-email', 'token' => $token], 'post') ?>

                    <div class="d-grid">
                        <?= Html::submitButton(
                            'Confirm email',
                            ['class' => 'btn login-btn btn-lg rounded-3 text-white'],
                        ) ?>
                    </div>

                    <?= Html::endForm() ?>

                    <div class="text-body-secondary text-center mt-3 small">
                        Wrong account? <?= Html::a('Login', ['user/login']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
