<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use InvalidArgumentException;
use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormPluginKernel;
use Iriven\Fluxa\Infrastructure\Registry\InMemoryFieldTypeRegistry;
use Iriven\Fluxa\Infrastructure\Registry\InMemoryFormTypeRegistry;
use Iriven\Fluxa\Tests\Fixtures\Plugin\DemoPlugin;
use Iriven\Fluxa\Tests\Fixtures\Plugin\EmptyPlugin;
use Iriven\Fluxa\Tests\Fixtures\Plugin\OverridePlugin;
use PHPUnit\Framework\TestCase;

final class PluginRuntimeRegressionTest extends TestCase
{
    public function testEmptyPluginCanBeRegisteredSafely(): void
    {
        $kernel = (new FormPluginKernel())->register(new EmptyPlugin());

        self::assertCount(1, $kernel->plugins()->all());
    }

    public function testPluginRegistrationOrderKeepsLatestAliasWhenOverrideAllowed(): void
    {
        $kernel = (new FormPluginKernel())
            ->register(new DemoPlugin())
            ->register(new OverridePlugin());

        self::assertSame(
            'Iriven\\Fluxa\\Tests\\Fixtures\\Plugin\\SlugType',
            $kernel->fieldTypes()->resolve('slug')
        );
        self::assertSame(
            'Iriven\\Fluxa\\Tests\\Fixtures\\Plugin\\NewsletterType',
            $kernel->formTypes()->resolve('newsletter')
        );
    }

    public function testFieldRegistryRejectsOverrideWhenDisabled(): void
    {
        $registry = new InMemoryFieldTypeRegistry([], false);
        $registry->register('slug', 'App\\One');

        $this->expectException(InvalidArgumentException::class);
        $registry->register('slug', 'App\\Two');
    }

    public function testFormRegistryRejectsOverrideWhenDisabled(): void
    {
        $registry = new InMemoryFormTypeRegistry([], false);
        $registry->register('newsletter', 'App\\One');

        $this->expectException(InvalidArgumentException::class);
        $registry->register('newsletter', 'App\\Two');
    }

    public function testFactoryStillWorksAfterMultiplePluginRegistrations(): void
    {
        $kernel = (new FormPluginKernel())
            ->register(new EmptyPlugin())
            ->register(new DemoPlugin())
            ->register(new OverridePlugin());

        $factory = new FormFactory(pluginKernel: $kernel);
        $form = $factory->create('newsletter');

        self::assertArrayHasKey('email', $form->fields());
    }
}
