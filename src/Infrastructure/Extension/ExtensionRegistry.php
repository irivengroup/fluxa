<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Infrastructure\Extension;

use Iriven\PhpFormGenerator\Domain\Contract\FieldTypeExtensionInterface;
use Iriven\PhpFormGenerator\Domain\Contract\FormExtensionInterface;

final class ExtensionRegistry
{
    /** @var list<FieldTypeExtensionInterface> */
    private array $fieldExtensions = [];

    /** @var list<FormExtensionInterface> */
    private array $formExtensions = [];

    public function addFieldTypeExtension(FieldTypeExtensionInterface $extension): void
    {
        $this->fieldExtensions[] = $extension;
    }

    public function addFormExtension(FormExtensionInterface $extension): void
    {
        $this->formExtensions[] = $extension;
    }

    /**
     * @param class-string $typeClass
     * @return list<FieldTypeExtensionInterface>
     */
    public function fieldExtensionsFor(string $typeClass): array
    {
        return array_values(array_filter(
            $this->fieldExtensions,
            static fn (FieldTypeExtensionInterface $extension): bool => $extension::getExtendedType() === $typeClass
        ));
    }

    /**
     * @return list<FormExtensionInterface>
     */
    public function formExtensions(): array
    {
        return $this->formExtensions;
    }
}
