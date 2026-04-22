<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Contract;

use Iriven\Fluxa\Infrastructure\Extension\ExtensionRegistry;

/**
 * @api
 */
interface PluginInterface
{
    public function registerFieldTypes(FieldTypeRegistryInterface $registry): void;

    public function registerFormTypes(FormTypeRegistryInterface $registry): void;

    public function registerExtensions(ExtensionRegistry $registry): void;
}
