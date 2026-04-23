<?php

declare(strict_types=1);

namespace app\tests;

use app\widgets\Alert;
use Yii;
use yii\web\Session;

/**
 * Unit tests for {@see Alert} verifying flash message rendering as Bootstrap 5 alerts.
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
final class AlertTest extends TestCase
{
    public function testRenderAppendsOptionsClassWhenProvided(): void
    {
        Yii::$app->session->setFlash('info', 'Heads up.');

        $html = Alert::widget(['options' => ['class' => 'custom-class']]);

        self::assertStringContainsString(
            'custom-class',
            $html,
            "Should append the user-supplied 'options.class' to the rendered alert class attribute.",
        );
        self::assertStringContainsString(
            'alert-info',
            $html,
            'Should keep the Bootstrap info alert class alongside the appended custom class.',
        );
    }

    public function testRenderEmptyWhenNoFlashes(): void
    {
        $html = Alert::widget();

        self::assertEmpty(
            $html,
            'Should render empty output when no flash messages are set.',
        );
    }

    public function testRenderFlashAsArray(): void
    {
        Yii::$app->session->setFlash('error', ['Error one.', 'Error two.']);

        $html = Alert::widget();

        self::assertStringContainsString(
            'alert-danger',
            $html,
            "Should render the Bootstrap danger alert class for an 'error' flash.",
        );
        self::assertStringContainsString(
            'Error one.',
            $html,
            'Should render the first message from a flash array.',
        );
        self::assertStringContainsString(
            'Error two.',
            $html,
            'Should render the second message from a flash array.',
        );
    }

    public function testRenderFlashAsSingleString(): void
    {
        Yii::$app->session->setFlash('success', 'Profile saved.');

        $html = Alert::widget();

        self::assertStringContainsString(
            'alert-success',
            $html,
            "Should render the Bootstrap success alert class for a 'success' flash.",
        );
        self::assertStringContainsString(
            'Profile saved.',
            $html,
            'Should include the flash message body in the rendered output.',
        );
    }

    public function testReturnsEmptyWhenSessionInactive(): void
    {
        $inactiveSession = self::createStub(Session::class);

        $inactiveSession->method('getIsActive')->willReturn(false);
        $inactiveSession->method('getHasSessionId')->willReturn(false);

        $originalSession = Yii::$app->session;

        Yii::$app->set('session', $inactiveSession);

        try {
            $html = Alert::widget();

            self::assertSame(
                '',
                $html,
                'Should return empty output when the session is inactive and has no session ID.',
            );
        } finally {
            Yii::$app->set('session', $originalSession);
        }
    }
    protected function setUp(): void
    {
        parent::setUp();

        $this->mockApplication();
    }

    protected function tearDown(): void
    {
        Yii::$app->session->removeAllFlashes();

        parent::tearDown();
    }
}
