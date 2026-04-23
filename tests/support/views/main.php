<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this View component instance.
 * @var string $widget Widget content to be rendered within the layout.
 */

$this->beginPage();
$this->head();
$this->beginBody();
echo $widget;
$this->endBody();
$this->endPage();
