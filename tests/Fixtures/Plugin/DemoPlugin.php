<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests\Fixtures\Plugin;

use Iriven\Fluxa\Domain\Contract\FieldTypeRegistryInterface;
use Iriven\Fluxa\Domain\Contract\FormTypeRegistryInterface;
use Iriven\Fluxa\Domain\Contract\PluginInterface;
use Iriven\Fluxa\Infrastructure\Extension\ExtensionRegistry;

final class DemoPlugin implements PluginInterface
{
    public function registerFieldTypes(FieldTypeRegistryInterface $registry): void
    {
        $registry->register('slug', SlugType::class);
    }

    public function registerFormTypes(FormTypeRegistryInterface $registry): void
    {
        $registry->register('newsletter', NewsletterType::class);
    }

    public function registerExtensions(ExtensionRegistry $registry): void
    {
        $registry->addFieldTypeExtension(new SlugTrimFieldExtension());
    }

    public function register(\Iriven\Fluxa\Infrastructure\Registry\PluginRegistry $registry): void
    {
        $registry->register($this);
    }
}
