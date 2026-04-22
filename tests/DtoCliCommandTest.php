<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\Cli\MakeDtoFormCommand;
use Iriven\Fluxa\Application\Cli\DebugDtoGuessCommand;
use PHPUnit\Framework\TestCase;

final class DtoCliCommandTest extends TestCase
{
    public function testMakeDtoFormReturnsJson(): void
    {
        self::assertNotFalse(json_decode((new MakeDtoFormCommand())->run(), true));
    }

    public function testDebugDtoGuessReturnsJson(): void
    {
        self::assertNotFalse(json_decode((new DebugDtoGuessCommand())->run(), true));
    }
}
