<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests;

use PHPUnit\Framework\TestCase;

final class BinCliRegressionTest extends TestCase
{
    public function testBinScriptExists(): void
    {
        self::assertFileExists(__DIR__ . '/../bin/php-form-generator');
    }
}
