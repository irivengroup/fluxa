<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests\Fixtures\Plugin;

use Iriven\Fluxa\Domain\Contract\FieldTypeExtensionInterface;
use Iriven\Fluxa\Domain\Transformer\StringTrimTransformer;

final class SlugTrimFieldExtension implements FieldTypeExtensionInterface
{
    public static function getExtendedType(): string
    {
        return SlugType::class;
    }

    public function extendOptions(array $options): array
    {
        return $options;
    }

    public function extendConstraints(array $constraints, array $options): array
    {
        return $constraints;
    }

    public function extendTransformers(array $transformers, array $options): array
    {
        array_unshift($transformers, new StringTrimTransformer());

        return $transformers;
    }
}
