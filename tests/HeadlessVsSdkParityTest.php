<?php
declare(strict_types=1);
namespace Iriven\Fluxa\Tests;
use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Application\Frontend\FrontendSdk;
use Iriven\Fluxa\Application\Headless\HeadlessFormProcessor;
use Iriven\Fluxa\Application\PublicApi\UnifiedSchemaExporter;
use Iriven\Fluxa\Infrastructure\Schema\ArraySchemaExporter;
use PHPUnit\Framework\TestCase;
final class HeadlessVsSdkParityTest extends TestCase
{
    public function testBothPipelinesExposeSchemaVersion(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $sdk = new FrontendSdk(new FormSchemaManager(new ArraySchemaExporter()));
        $unified = (new UnifiedSchemaExporter($sdk))->export($form);
        $headless = (new HeadlessFormProcessor())->schema($form);
        self::assertArrayHasKey('version', $unified['schema']);
        self::assertArrayHasKey('version', $headless['schema']);
    }
}
