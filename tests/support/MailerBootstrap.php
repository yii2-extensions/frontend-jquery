<?php

declare(strict_types=1);

namespace app\tests\support;

use Yii;
use yii\base\{Application, BootstrapInterface};
use yii\mail\MailerInterface;

/**
 * Registers the application mailer component as the DI container singleton for {@see MailerInterface}.
 *
 * Controllers and services that type-hint {@see MailerInterface} through the DI container receive the same instance
 * configured under `components.mailer`, keeping runtime and test wiring consistent.
 */
final class MailerBootstrap implements BootstrapInterface
{
    /**
     * @param Application $app Application instance.
     */
    public function bootstrap($app): void
    {
        Yii::$container->setSingleton(MailerInterface::class, $app->mailer);
    }
}
