<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\Cli\DebugCacheCommand;
use Iriven\Fluxa\Application\Cli\DebugEventsCommand;
use Iriven\Fluxa\Application\Cli\DebugFormCommand;
use Iriven\Fluxa\Application\Cli\DebugPipelineCommand;
use PHPUnit\Framework\TestCase;

final class DebugRuntimeCliRegressionTest extends TestCase
{
    public function testAllRuntimeDebugCommandsAlwaysReturnJson(): void
    {
        self::assertNotFalse(json_decode((new DebugFormCommand())->run(), true));
        self::assertNotFalse(json_decode((new DebugPipelineCommand())->run(), true));
        self::assertNotFalse(json_decode((new DebugEventsCommand())->run(), true));
        self::assertNotFalse(json_decode((new DebugCacheCommand())->run(), true));
    }
}
