<?php
declare(strict_types=1);
namespace Iriven\Fluxa\Tests;
use Iriven\Fluxa\Application\Cli\DebugHeadlessContractCommand;
use Iriven\Fluxa\Application\Cli\DebugHeadlessSubmissionCommand;
use PHPUnit\Framework\TestCase;
final class HeadlessCliRegressionTest extends TestCase
{
    public function testDebugHeadlessContractIsAlwaysValidJson(): void
    {
        self::assertNotFalse(json_decode((new DebugHeadlessContractCommand())->run(), true));
    }
    public function testDebugHeadlessSubmissionIsAlwaysValidJson(): void
    {
        self::assertNotFalse(json_decode((new DebugHeadlessSubmissionCommand())->run(), true));
    }
}
