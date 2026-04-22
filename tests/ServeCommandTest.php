<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\Cli\ServeCommand;
use PHPUnit\Framework\TestCase;

final class ServeCommandTest extends TestCase
{
    public function testServeCommandReturnsJson(): void
    {
        self::assertNotFalse(json_decode((new ServeCommand())->run(['9090']), true));
    }
}
