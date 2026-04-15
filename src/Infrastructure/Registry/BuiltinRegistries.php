<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Infrastructure\Registry;

use Iriven\PhpFormGenerator\Infrastructure\Type\BuiltinTypeRegistry;

final class BuiltinRegistries
{
    public static function fieldTypes(): InMemoryFieldTypeRegistry
    {
        return new InMemoryFieldTypeRegistry(BuiltinTypeRegistry::fieldTypes());
    }

    public static function formTypes(): InMemoryFormTypeRegistry
    {
        return new InMemoryFormTypeRegistry(BuiltinTypeRegistry::formTypes());
    }
}
