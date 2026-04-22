<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\Cli\DebugDtoMetadataCommand;
use PHPUnit\Framework\TestCase;

final class DtoMetadataCliRegressionTest extends TestCase
{
    public function testDebugDtoMetadataAlwaysReturnsValidJson(): void
    {
        self::assertNotFalse(json_decode((new DebugDtoMetadataCommand())->run(), true));
    }
}
