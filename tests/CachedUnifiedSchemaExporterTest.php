<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\Dx\CachedUnifiedSchemaExporter;
use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Application\Frontend\FrontendSdk;
use Iriven\Fluxa\Application\PublicApi\UnifiedSchemaExporter;
use Iriven\Fluxa\Infrastructure\Schema\ArraySchemaExporter;
use PHPUnit\Framework\TestCase;

final class CachedUnifiedSchemaExporterTest extends TestCase
{
    public function testCachedExporterReturnsStableSchema(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $sdk = new FrontendSdk(new FormSchemaManager(new ArraySchemaExporter()));
        $exporter = new CachedUnifiedSchemaExporter(new UnifiedSchemaExporter($sdk));

        self::assertSame($exporter->export($form), $exporter->export($form));
    }
}
