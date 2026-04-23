<?php
declare(strict_types=1);

namespace Iriven\Fluxon\Application\Plugins;

final class PluginContext
{
    public function __construct(private array $config = []) {}

    public function config(): array
    {
        return $this->config;
    }
}
