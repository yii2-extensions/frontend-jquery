<?php

declare(strict_types=1);

namespace app\tests;

use app\controllers\UserController;
use app\models\User;
use app\tests\support\fixtures\UserFixture;
use Yii;

/**
 * Unit tests for {@see UserController} verifying jQuery + Bootstrap 5 view rendering.
 *
 * {@see UserFixture} for test case data providers.
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
final class UserControllerTest extends TestCase
{
    private UserFixture|null $fixture = null;

    public function testRenderIndexContainsUsersGrid(): void
    {
        $_SERVER['REQUEST_URI'] = '/user';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $controller = new UserController('user', Yii::$app, Yii::$app->mailer);

        Yii::$app->controller = $controller;

        $html = $controller->actionIndex();

        self::assertIsString(
            $html,
            'Should return the rendered HTML as a string.',
        );
        self::assertStringContainsString(
            'id="users-pjax"',
            $html,
            "Users index should render the Pjax container with id 'users-pjax'.",
        );
        self::assertStringContainsString(
            'admin',
            $html,
            "Users grid should include the seeded 'admin' user row.",
        );
    }

    public function testRenderLoginContainsLoginForm(): void
    {
        $_SERVER['REQUEST_URI'] = '/user/login';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $controller = new UserController('user', Yii::$app, Yii::$app->mailer);

        Yii::$app->controller = $controller;

        $html = $controller->actionLogin();

        self::assertIsString(
            $html,
            'Should return the rendered HTML as a string.',
        );
        self::assertStringContainsString(
            'id="login-form"',
            $html,
            "Login page should render the form with id 'login-form'.",
        );
        self::assertStringContainsString(
            'name="LoginForm[username]"',
            $html,
            'Login form should expose the username input bound.',
        );
        self::assertStringContainsString(
            'name="LoginForm[password]"',
            $html,
            'Login form should expose the password input bound.',
        );
    }

    public function testRenderRequestPasswordResetContainsForm(): void
    {
        $_SERVER['REQUEST_URI'] = '/user/request-password-reset';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $controller = new UserController('user', Yii::$app, Yii::$app->mailer);

        Yii::$app->controller = $controller;

        $html = $controller->actionRequestPasswordReset();

        self::assertIsString(
            $html,
            'Should return the rendered HTML as a string.',
        );
        self::assertStringContainsString(
            'id="request-password-reset-form"',
            $html,
            "Password reset request page should render the form with id 'request-password-reset-form'.",
        );
        self::assertStringContainsString(
            'name="PasswordResetRequestForm[email]"',
            $html,
            'Password reset request form should expose the email input bound.',
        );
    }

    public function testRenderResendVerificationEmailContainsForm(): void
    {
        $_SERVER['REQUEST_URI'] = '/user/resend-verification-email';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $controller = new UserController('user', Yii::$app, Yii::$app->mailer);

        Yii::$app->controller = $controller;

        $html = $controller->actionResendVerificationEmail();

        self::assertIsString(
            $html,
            'Should return the rendered HTML as a string.',
        );
        self::assertStringContainsString(
            'id="resend-verification-email-form"',
            $html,
            'Resend verification page should render the form with id `resend-verification-email-form`.',
        );
        self::assertStringContainsString(
            'name="ResendVerificationEmailForm[email]"',
            $html,
            'Resend verification form should expose the email input bound.',
        );
    }

    public function testRenderResetPasswordContainsFormWithToken(): void
    {
        $_SERVER['REQUEST_URI'] = '/user/reset-password';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $user = User::findOne(['username' => 'okirlin']);

        self::assertInstanceOf(
            User::class,
            $user,
            "Fixture user 'okirlin' must exist.",
        );
        self::assertNotNull(
            $user->password_reset_token,
            "Fixture user 'okirlin' must have a password reset token.",
        );

        $controller = new UserController('user', Yii::$app, Yii::$app->mailer);

        Yii::$app->controller = $controller;

        $html = $controller->actionResetPassword($user->password_reset_token);

        self::assertIsString(
            $html,
            'Should return the rendered HTML as a string.',
        );
        self::assertStringContainsString(
            'id="reset-password-form"',
            $html,
            "Reset password page should render the form with id 'reset-password-form'.",
        );
        self::assertStringContainsString(
            'name="ResetPasswordForm[password]"',
            $html,
            'Reset password form should expose the new-password input bound.',
        );
    }

    public function testRenderSignupContainsForm(): void
    {
        $_SERVER['REQUEST_URI'] = '/user/signup';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $controller = new UserController('user', Yii::$app, Yii::$app->mailer);

        Yii::$app->controller = $controller;

        $html = $controller->actionSignup();

        self::assertIsString(
            $html,
            'Should return the rendered HTML as a string.',
        );
        self::assertStringContainsString(
            'id="form-signup"',
            $html,
            "Should render the form with id 'form-signup'.",
        );
        self::assertStringContainsString(
            'name="SignupForm[username]"',
            $html,
            'Should expose the username input bound.',
        );
        self::assertStringContainsString(
            'name="SignupForm[email]"',
            $html,
            'Should expose the email input bound.',
        );
        self::assertStringContainsString(
            'name="SignupForm[password]"',
            $html,
            'Should expose the password input bound.',
        );
    }

    public function testRenderVerifyEmailContainsConfirmFormWithToken(): void
    {
        $_SERVER['REQUEST_URI'] = '/user/verify-email';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $user = User::findOne(['username' => 'test.test']);

        self::assertInstanceOf(
            User::class,
            $user,
            "Fixture user 'test.test' must exist.",
        );
        self::assertNotNull(
            $user->verification_token,
            "Fixture user 'test.test' must have a verification token.",
        );

        $controller = new UserController('user', Yii::$app, Yii::$app->mailer);

        Yii::$app->controller = $controller;

        $token = $user->verification_token;

        $html = $controller->actionVerifyEmail($token);

        self::assertIsString(
            $html,
            'Should return the rendered HTML as a string.',
        );
        self::assertStringContainsString(
            'Confirm email',
            $html,
            "Verify email page should display the 'Confirm email' call to action.",
        );
        self::assertStringContainsString(
            'user/confirm-email',
            $html,
            "Verify email page should link the confirmation form to the 'user/confirm-email' action.",
        );
        self::assertStringContainsString(
            $token,
            $html,
            'Verify email page should embed the user verification token into the confirmation form.',
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockApplication();

        $this->fixture = new UserFixture(['dataFile' => __DIR__ . '/support/data/user.php']);

        $this->fixture->load();
    }

    protected function tearDown(): void
    {
        Yii::$app->request->setBodyParams([]);
        Yii::$app->controller = null;
        Yii::$app->session->removeAllFlashes();

        unset(
            $_SERVER['REQUEST_URI'],
            $_SERVER['SERVER_NAME'],
            $_SERVER['REQUEST_METHOD'],
        );

        $this->fixture?->unload();

        parent::tearDown();
    }
}
