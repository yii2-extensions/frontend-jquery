<?php

declare(strict_types=1);

namespace app\tests;

use app\assets\AppAsset;
use Yii;
use yii\bootstrap5\BootstrapAsset;
use yii\web\{JqueryAsset, View, YiiAsset};

/**
 * Unit tests for {@see AppAsset} verifying asset bundle registration and rendered CSS/JS paths.
 *
 * @author Wilmer Arambula <terabytesoftw@gmail.com>
 * @since 0.1
 */
final class AssetTest extends TestCase
{
    public function testAppAssetRegister(): void
    {
        $view = Yii::$app->getView();

        self::assertInstanceOf(
            View::class,
            $view,
            "Should be able to retrieve a '\yii\web\View' instance.",
        );
        self::assertEmpty(
            $view->assetBundles,
            "Should start with no registered asset bundles before 'AppAsset::register()'.",
        );

        AppAsset::register($view);

        self::assertCount(
            4,
            $view->assetBundles,
            "Should produce '4' bundles in the view.",
        );

        $result = $view->renderFile(__DIR__ . '/support/views/main.php', ['widget' => '']);

        self::assertStringContainsString(
            'css/site.css',
            $result,
            "Rendered HTML should contain the 'css/site.css' stylesheet declared by 'AppAsset'.",
        );
        self::assertStringContainsString(
            'js/color-mode.js',
            $result,
            "Rendered HTML should contain the 'js/color-mode.js' script declared by 'AppAsset'.",
        );
    }

    public function testAppAssetSimpleDependency(): void
    {
        $view = Yii::$app->getView();

        self::assertInstanceOf(
            View::class,
            $view,
            "Should be able to retrieve a '\yii\web\View' instance.",
        );
        self::assertEmpty(
            $view->assetBundles,
            "Should start with no registered asset bundles before 'AppAsset::register()'.",
        );

        AppAsset::register($view);

        self::assertCount(
            4,
            $view->assetBundles,
            "Should produce '4' bundles in the view.",
        );
        self::assertArrayHasKey(
            AppAsset::class,
            $view->assetBundles,
            'Should be present in the registered asset bundles.',
        );
        self::assertArrayHasKey(
            BootstrapAsset::class,
            $view->assetBundles,
            "Should be registered as a direct dependency of 'AppAsset'.",
        );
        self::assertArrayHasKey(
            YiiAsset::class,
            $view->assetBundles,
            "Should be registered as a direct dependency of 'AppAsset'.",
        );
        self::assertArrayHasKey(
            JqueryAsset::class,
            $view->assetBundles,
            "Should be registered as a transitive dependency through 'YiiAsset'.",
        );
    }
    protected function setUp(): void
    {
        parent::setUp();

        $this->mockApplication();
    }
}
