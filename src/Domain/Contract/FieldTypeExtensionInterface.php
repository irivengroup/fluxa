<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Contract;

interface FieldTypeExtensionInterface
{
    /**
     * @return class-string
     */
    public static function getExtendedType(): string;

    /**
     * @param array<string, mixed> $options
     * @return array<string, mixed>
     */
    public function extendOptions(array $options): array;

    /**
     * @param list<ConstraintInterface> $constraints
     * @return list<ConstraintInterface>
     */
    public function extendConstraints(array $constraints, array $options): array;

    /**
     * @param list<DataTransformerInterface> $transformers
     * @return list<DataTransformerInterface>
     */
    public function extendTransformers(array $transformers, array $options): array;
}
