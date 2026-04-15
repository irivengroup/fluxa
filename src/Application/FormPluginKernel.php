<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Application;

use Iriven\PhpFormGenerator\Domain\Contract\PluginInterface;
use Iriven\PhpFormGenerator\Infrastructure\Extension\ExtensionRegistry;
use Iriven\PhpFormGenerator\Infrastructure\Registry\BuiltinRegistries;
use Iriven\PhpFormGenerator\Infrastructure\Registry\PluginRegistry;

final class FormPluginKernel
{
    private PluginRegistry $plugins;

    public function __construct(?ExtensionRegistry $extensionRegistry = null)
    {
        $this->plugins = new PluginRegistry(
            BuiltinRegistries::fieldTypes(),
            BuiltinRegistries::formTypes(),
            $extensionRegistry ?? new ExtensionRegistry(),
        );
    }

    public function register(PluginInterface $plugin): self
    {
        $this->plugins->registerPlugin($plugin);

        return $this;
    }

    public function plugins(): PluginRegistry
    {
        return $this->plugins;
    }
}
