<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Infrastructure\Registry;

use Iriven\PhpFormGenerator\Domain\Contract\PluginInterface;
use Iriven\PhpFormGenerator\Infrastructure\Extension\ExtensionRegistry;

final class PluginRegistry
{
    /** @var array<int, PluginInterface> */
    private array $plugins = [];

    public function __construct(
        private readonly InMemoryFieldTypeRegistry $fieldTypeRegistry,
        private readonly InMemoryFormTypeRegistry $formTypeRegistry,
        private readonly ExtensionRegistry $extensionRegistry,
    ) {
    }

    public function registerPlugin(PluginInterface $plugin): void
    {
        $plugin->registerFieldTypes($this->fieldTypeRegistry);
        $plugin->registerFormTypes($this->formTypeRegistry);
        $plugin->registerExtensions($this->extensionRegistry);
        $this->plugins[] = $plugin;
    }

    /**
     * @return array<int, PluginInterface>
     */
    public function all(): array
    {
        return $this->plugins;
    }
}
