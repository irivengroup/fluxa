<?php
declare(strict_types=1);
namespace Iriven\Fluxa\Tests;
use Iriven\Fluxa\Application\Headless\HeadlessFormState;
use Iriven\Fluxa\Application\Headless\HeadlessResponseBuilder;
use PHPUnit\Framework\TestCase;
final class HeadlessResponseBuilderTest extends TestCase
{
    public function testHeadlessResponseContainsExpectedKeys(): void
    {
        $payload = (new HeadlessResponseBuilder())->build(new HeadlessFormState(true, true, ['name' => 'John'], [], ['mode' => 'submit']));
        self::assertSame(['state', 'payload', 'errors', 'metadata'], array_keys($payload));
    }
}
