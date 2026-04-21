<?php
declare(strict_types=1);
namespace Iriven\PhpFormGenerator\Tests;
use Iriven\PhpFormGenerator\Application\FormFactory;
use Iriven\PhpFormGenerator\Application\FormRuntimeContext;
use Iriven\PhpFormGenerator\Application\FormSchemaManager;
use Iriven\PhpFormGenerator\Application\Frontend\FrontendSdk;
use Iriven\PhpFormGenerator\Application\Headless\HeadlessFormProcessor;
use Iriven\PhpFormGenerator\Application\PublicApi\FullPipelineConsistencyInspector;
use Iriven\PhpFormGenerator\Application\PublicApi\UnifiedSchemaExporter;
use Iriven\PhpFormGenerator\Infrastructure\Schema\ArraySchemaExporter;
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
