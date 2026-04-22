<?php
declare(strict_types=1);
namespace Iriven\Fluxa\Tests;
use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Application\Frontend\FrontendSdk;
use Iriven\Fluxa\Application\PublicApi\PublicApiStabilityChecker;
use Iriven\Fluxa\Application\PublicApi\UnifiedSchemaExporter;
use Iriven\Fluxa\Infrastructure\Schema\ArraySchemaExporter;
use PHPUnit\Framework\TestCase;
final class PublicApiStabilityTest extends TestCase
{
    public function testUnifiedSchemaContainsAllStableKeys(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $sdk = new FrontendSdk(new FormSchemaManager(new ArraySchemaExporter()));
        $schema = (new UnifiedSchemaExporter($sdk))->export($form);
        self::assertTrue((new PublicApiStabilityChecker())->isStable($schema));
    }
}
