<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests\Fixtures\Plugin;

use Iriven\Fluxa\Domain\Contract\FieldTypeRegistryInterface;
use Iriven\Fluxa\Domain\Contract\FormTypeRegistryInterface;
use Iriven\Fluxa\Domain\Contract\PluginInterface;
use Iriven\Fluxa\Infrastructure\Extension\ExtensionRegistry;

final class EmptyPlugin implements PluginInterface
{
    public function registerFieldTypes(FieldTypeRegistryInterface $registry): void
    {
    }

    public function registerFormTypes(FormTypeRegistryInterface $registry): void
    {
    }

    public function registerExtensions(ExtensionRegistry $registry): void
    {
    }

    public function register(\Iriven\Fluxa\Infrastructure\Registry\PluginRegistry $registry): void
    {
        $registry->register($this);
    }
}
