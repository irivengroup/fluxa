<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Application;

use Iriven\Fluxa\Application\Plugin\PluginValidator;
use Iriven\Fluxa\Domain\Contract\PluginInterface;
use Iriven\Fluxa\Infrastructure\Extension\ExtensionRegistry;
use Iriven\Fluxa\Infrastructure\Registry\BuiltinRegistries;
use Iriven\Fluxa\Infrastructure\Registry\InMemoryFieldTypeRegistry;
use Iriven\Fluxa\Infrastructure\Registry\InMemoryFormTypeRegistry;
use Iriven\Fluxa\Infrastructure\Registry\PluginRegistry;
use Iriven\Fluxa\Infrastructure\Type\TypeResolver;

final class FormPluginKernel
{
    private PluginRegistry $plugins;

    public function __construct(
        ?ExtensionRegistry $extensionRegistry = null,
        private readonly ?PluginValidator $pluginValidator = null,
    ) {
        $this->plugins = new PluginRegistry(
            BuiltinRegistries::fieldTypes(),
            BuiltinRegistries::formTypes(),
            $extensionRegistry ?? new ExtensionRegistry(),
        );

        $this->bootRuntime();
    }

    public function register(PluginInterface $plugin): self
    {
        ($this->pluginValidator ?? new PluginValidator())->validate($plugin);
        $this->plugins->registerPlugin($plugin);
        $this->bootRuntime();

        return $this;
    }

    public function plugins(): PluginRegistry
    {
        return $this->plugins;
    }

    public function registry(): PluginRegistry
    {
        return $this->plugins;
    }

    public function fieldTypes(): InMemoryFieldTypeRegistry
    {
        return $this->plugins->fieldTypes();
    }

    public function formTypes(): InMemoryFormTypeRegistry
    {
        return $this->plugins->formTypes();
    }

    public function extensions(): ExtensionRegistry
    {
        return $this->plugins->extensions();
    }

    private function bootRuntime(): void
    {
        TypeResolver::useRegistries($this->fieldTypes(), $this->formTypes());
    }
}
