<?php
declare(strict_types=1);
namespace Iriven\Fluxa\Tests;
use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormRuntimeContext;
use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Application\Frontend\FrontendSdk;
use Iriven\Fluxa\Application\Headless\HeadlessFormProcessor;
use Iriven\Fluxa\Application\PublicApi\FullPipelineConsistencyInspector;
use Iriven\Fluxa\Application\PublicApi\UnifiedSchemaExporter;
use Iriven\Fluxa\Infrastructure\Schema\ArraySchemaExporter;
use PHPUnit\Framework\TestCase;
final class FullPipelineConsistencyTest extends TestCase
{
    public function testSdkAndHeadlessStayConsistent(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $runtime = new FormRuntimeContext($form, 'default', 'RendererClass', ['channel' => 'headless']);
        $sdk = new FrontendSdk(new FormSchemaManager(new ArraySchemaExporter()));
        $inspector = new FullPipelineConsistencyInspector(new UnifiedSchemaExporter($sdk), new HeadlessFormProcessor());
        self::assertTrue($inspector->isConsistent($form, $runtime));
    }
}
