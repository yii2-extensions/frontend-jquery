<?php

declare(strict_types=1);

defined('YII_DEBUG') || define('YII_DEBUG', true);
defined('YII_ENV') || define('YII_ENV', 'test');

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/vendor/yiisoft/yii2/Yii.php';

// Run app-base migrations against the test database once before the suite.
$app = new yii\console\Application(
    [
        'id' => 'frontend-jquery-test-migrate',
        'basePath' => dirname(__DIR__),
        'aliases' => [
            '@app/migrations' => '@vendor/yii2-extensions/app-base/src/migrations',
        ],
        'components' => ['db' => require dirname(__DIR__) . '/config/test_db.php'],
        'params' => require dirname(__DIR__) . '/config/params.php',
        'controllerMap' => [
            'migrate' => [
                'class' => yii\console\controllers\MigrateController::class,
                'migrationNamespaces' => ['app\\migrations'],
                'migrationPath' => null,
                'interactive' => false,
                'compact' => true,
            ],
        ],
    ],
);

$app->runAction('migrate/up');

$app = null;

// @phpstan-ignore assign.propertyType
Yii::$app = null;
