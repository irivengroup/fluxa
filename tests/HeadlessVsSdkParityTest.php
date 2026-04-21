<?php
declare(strict_types=1);
namespace Iriven\PhpFormGenerator\Tests;
use Iriven\PhpFormGenerator\Application\FormFactory;
use Iriven\PhpFormGenerator\Application\FormSchemaManager;
use Iriven\PhpFormGenerator\Application\Frontend\FrontendSdk;
use Iriven\PhpFormGenerator\Application\Headless\HeadlessFormProcessor;
use Iriven\PhpFormGenerator\Application\PublicApi\UnifiedSchemaExporter;
use Iriven\PhpFormGenerator\Infrastructure\Schema\ArraySchemaExporter;
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
