<?php
declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Infrastructure\Extension;

use Iriven\PhpFormGenerator\Domain\Contract\ExtensionInterface;

/**
 * @api
 */
final class ExtensionRegistry
{
    /** @var array<int, object> */
    private array $fieldTypeExtensions = [];

    /** @var array<int, object> */
    private array $formTypeExtensions = [];

    public function addFieldTypeExtension(object $extension): void
    {
        $this->fieldTypeExtensions[] = $extension;
    }

    public function addFormTypeExtension(object $extension): void
    {
        $this->formTypeExtensions[] = $extension;
    }

    /**
     * @return array<int, object>
     */
    public function all(): array
    {
        return array_values(array_merge($this->fieldTypeExtensions, $this->formTypeExtensions));
    }

    /**
     * @return array<int, object>
     */
    public function for(string $type): array
    {
        return array_values(array_filter(
            $this->fieldTypeExtensions,
            static function (object $extension) use ($type): bool {
                if (!$extension instanceof ExtensionInterface) {
                    return false;
                }

                return $extension->supports($type);
            }
        ));
    }

    /**
     * @return array<int, object>
     */
    public function fieldExtensionsFor(string $type): array
    {
        return array_values(array_filter(
            $this->fieldTypeExtensions,
            static function (object $extension) use ($type): bool {
                if ($extension instanceof ExtensionInterface) {
                    return $extension->supports($type);
                }

                return false;
            }
        ));
    }

    /**
     * @return array<int, object>
     */
    public function formExtensions(): array
    {
        return array_values($this->formTypeExtensions);
    }
}
