<?php
declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests;

use Iriven\PhpFormGenerator\Application\Dx\CachedUnifiedSchemaExporter;
use Iriven\PhpFormGenerator\Application\FormFactory;
use Iriven\PhpFormGenerator\Application\FormSchemaManager;
use Iriven\PhpFormGenerator\Application\Frontend\FrontendSdk;
use Iriven\PhpFormGenerator\Application\PublicApi\UnifiedSchemaExporter;
use Iriven\PhpFormGenerator\Infrastructure\Schema\ArraySchemaExporter;
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
