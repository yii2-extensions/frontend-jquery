<?php

declare(strict_types=1);

namespace app\tests;

use Yii;
use yii\di\Container;
use yii\helpers\ArrayHelper;
use yii\web\Application;

/**
 * Base class for PHPUnit test cases that require a mocked Yii web application.
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function destroyApplication(): void
    {
        if (Yii::$app !== null) {
            Yii::$app->getErrorHandler()->unregister();
        }

        // @phpstan-ignore assign.propertyType
        Yii::$app = null;
        Yii::$container = new Container();
    }

    /**
     * @param array<string, mixed> $overrides Additional configuration merged over `config/test.php`.
     */
    protected function mockApplication(array $overrides = []): void
    {
        /** @phpstan-var array<string, mixed> $config */
        $config = require dirname(__DIR__) . '/config/test.php';

        new Application(ArrayHelper::merge($config, $overrides));
    }
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->destroyApplication();
    }
}
