<?php
declare(strict_types=1);

namespace Iriven\Fluxon\Application\Ecosystem;

use Iriven\Fluxon\Application\Plugins\OfficialPluginInterface;

final class PluginCatalog
{
    private array $plugins = [];

    public function register(OfficialPluginInterface $plugin): void
    {
        $this->plugins[] = $plugin;
    }

    public function all(): array
    {
        return $this->plugins;
    }
}
