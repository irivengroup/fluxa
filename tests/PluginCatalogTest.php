<?php
declare(strict_types=1);

namespace Iriven\Fluxon\Tests;

use Iriven\Fluxon\Application\Ecosystem\PluginCatalog;
use Iriven\Fluxon\Application\Plugins\CsrfPlugin;
use PHPUnit\Framework\TestCase;

final class PluginCatalogTest extends TestCase
{
    public function testPluginCanBeRegistered(): void
    {
        $catalog = new PluginCatalog();
        $catalog->register(new CsrfPlugin());

        self::assertCount(1, $catalog->all());
    }
}
