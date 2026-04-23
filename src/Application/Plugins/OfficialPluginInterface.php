<?php
declare(strict_types=1);

namespace Iriven\Fluxon\Application\Plugins;

interface OfficialPluginInterface
{
    public function name(): string;
    public function version(): string;
    public function register(PluginContext $context): void;
}
