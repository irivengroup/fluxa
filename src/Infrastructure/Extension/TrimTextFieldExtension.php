<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Infrastructure\Extension;

use Iriven\Fluxa\Domain\Contract\ConstraintInterface;
use Iriven\Fluxa\Domain\Contract\DataTransformerInterface;
use Iriven\Fluxa\Domain\Contract\FieldTypeExtensionInterface;
use Iriven\Fluxa\Domain\Field\TextType;
use Iriven\Fluxa\Domain\Transformer\StringTrimTransformer;

final class TrimTextFieldExtension implements FieldTypeExtensionInterface
{
    public static function getExtendedType(): string
    {
        return TextType::class;
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
