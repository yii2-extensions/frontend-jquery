<?php

declare(strict_types=1);

use app\models\User;
use app\tests\support\MailerBootstrap;
use yii\caching\FileCache;
use yii\jquery\Bootstrap;
use yii\rbac\PhpManager;
use yii\symfonymailer\{Mailer, Message};
use yii\web\JsonParser;

/** @var array<string, mixed> $params */
$params = require __DIR__ . '/params.php';

return [
    'id' => 'app-frontend-jquery-test',
    'aliases' => [
        '@npm' => dirname(__DIR__) . '/node_modules',
        '@web' => '/',
        '@webroot' => dirname(__DIR__) . '/public',
    ],
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        Bootstrap::class,
        MailerBootstrap::class,
    ],
    'components' => [
        'assetManager' => [
            'basePath' => '@runtime/assets',
        ],
        'authManager' => [
            'class' => PhpManager::class,
        ],
        'cache' => [
            'class' => FileCache::class,
        ],
        'db' => require __DIR__ . '/test_db.php',
        'mailer' => [
            'class' => Mailer::class,
            'messageClass' => Message::class,
            'useFileTransport' => true,
            'viewPath' => '@vendor/yii2-extensions/app-base/resources/mail',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => JsonParser::class,
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'user' => [
            'identityClass' => User::class,
            'loginUrl' => ['user/login'],
        ],
    ],
    'controllerNamespace' => 'app\\controllers',
    'language' => 'en-US',
    'params' => [...$params, 'turnstile.secretKey' => ''],
    'viewPath' => '@app/resources/views',
];
