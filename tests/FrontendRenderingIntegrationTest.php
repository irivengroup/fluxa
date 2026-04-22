<?php
declare(strict_types=1);
namespace Iriven\Fluxa\Tests;
use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormRuntimeContext;
use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Application\Frontend\FrontendSdk;
use Iriven\Fluxa\Application\Rendering\RenderProfileManager;
use Iriven\Fluxa\Application\Rendering\ThemeDefinition;
use Iriven\Fluxa\Application\Rendering\ThemeRegistry;
use Iriven\Fluxa\Application\Rendering\ThemeResolver;
use Iriven\Fluxa\Infrastructure\Schema\ArraySchemaExporter;
use PHPUnit\Framework\TestCase;
final class FrontendRenderingIntegrationTest extends TestCase
{
    public function testFrontendSchemaContainsRenderingMetadata(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $sdk = new FrontendSdk(
            new FormSchemaManager(new ArraySchemaExporter()),
            renderProfileManager: new RenderProfileManager(
                new ThemeResolver(new ThemeRegistry([new ThemeDefinition('default'), new ThemeDefinition('tailwind', 'default')]))
            )
        );
        $schema = $sdk->buildSchema($form, new FormRuntimeContext($form, 'tailwind', 'RendererClass', ['channel' => 'headless']));
        self::assertSame('tailwind', $schema['runtime']['rendering']['theme']);
        self::assertSame('headless', $schema['runtime']['rendering']['channel']);
        self::assertArrayHasKey('theme_components', $schema['runtime']['rendering']);
    }
}
