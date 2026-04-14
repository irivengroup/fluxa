<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Infrastructure\Extension;

use Iriven\PhpFormGenerator\Domain\Contract\ConstraintInterface;
use Iriven\PhpFormGenerator\Domain\Contract\DataTransformerInterface;
use Iriven\PhpFormGenerator\Domain\Contract\FieldTypeExtensionInterface;
use Iriven\PhpFormGenerator\Domain\Field\TextType;
use Iriven\PhpFormGenerator\Domain\Transformer\StringTrimTransformer;

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
