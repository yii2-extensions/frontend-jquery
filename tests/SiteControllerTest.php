<?php

declare(strict_types=1);

namespace app\tests;

use app\controllers\SiteController;
use RuntimeException;
use Yii;

/**
 * Unit tests for {@see SiteController} verifying jQuery + Bootstrap 5 view rendering.
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
final class SiteControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->mockApplication();
    }

    public function testRenderAboutContainsAboutHeading(): void
    {
        $_SERVER['REQUEST_URI'] = '/site/about';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $controller = new SiteController('site', Yii::$app, Yii::$app->mailer);

        Yii::$app->controller = $controller;

        $html = $controller->actionAbout();

        self::assertIsString(
            $html,
            'Should return the rendered HTML as a string.',
        );
        self::assertStringContainsString(
            'This is the About page.',
            $html,
            'About page should include its introductory copy.',
        );
    }

    public function testRenderContactContainsContactForm(): void
    {
        $_SERVER['REQUEST_URI'] = '/site/contact';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $controller = new SiteController('site', Yii::$app, Yii::$app->mailer);

        Yii::$app->controller = $controller;

        $html = $controller->actionContact();

        self::assertIsString(
            $html,
            'Should return the rendered HTML as a string.',
        );
        self::assertStringContainsString(
            'id="contact-form"',
            $html,
            "Should render the contact form with id 'contact-form'.",
        );
        self::assertStringContainsString(
            'name="ContactForm[name]"',
            $html,
            "Should render the contact form with input 'name' bound.",

        );
        self::assertStringContainsString(
            'name="ContactForm[email]"',
            $html,
            "Should render the contact form with input 'email' bound.",
        );
        self::assertStringContainsString(
            'name="ContactForm[subject]"',
            $html,
            "Should render the contact form with input 'subject' bound.",
        );
        self::assertStringContainsString(
            'name="ContactForm[body]"',
            $html,
            "Should render the contact form with textarea 'body' bound.",
        );
    }

    public function testRenderErrorContainsStatusAndMessage(): void
    {
        $_SERVER['REQUEST_URI'] = '/site/error';
        $_SERVER['SERVER_NAME'] = 'localhost';

        $controller = new SiteController('site', Yii::$app, Yii::$app->mailer);

        Yii::$app->controller = $controller;
        Yii::$app->errorHandler->exception = new RuntimeException('Boom!');

        $html = $controller->actionError();

        self::assertIsString(
            $html,
            'Should return the rendered HTML as a string.',
        );
        self::assertStringContainsString(
            '500',
            $html,
            "Error page should display the HTTP status code ('500') for a generic RuntimeException.",
        );
        self::assertStringContainsString(
            'Boom!',
            $html,
            "Error page should surface the exception message ('Boom!').",
        );
    }

    public function testRenderIndexContainsHeroHeading(): void
    {
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['SERVER_NAME'] = 'localhost';

        $controller = new SiteController('site', Yii::$app, Yii::$app->mailer);

        Yii::$app->controller = $controller;

        $html = $controller->actionIndex();

        self::assertIsString(
            $html,
            'Should return the rendered HTML as a string.',
        );
        self::assertStringContainsString(
            'Build with Yii Framework',
            $html,
            'Landing page should display the hero heading.',
        );
    }

    protected function tearDown(): void
    {
        Yii::$app->request->setBodyParams([]);
        Yii::$app->controller = null;
        Yii::$app->errorHandler->exception = null;
        Yii::$app->session->removeAllFlashes();

        unset(
            $_SERVER['REQUEST_URI'],
            $_SERVER['SERVER_NAME'],
            $_SERVER['REQUEST_METHOD'],
        );

        parent::tearDown();
    }
}
