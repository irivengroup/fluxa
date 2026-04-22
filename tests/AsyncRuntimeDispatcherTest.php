<?php
declare(strict_types=1);

namespace Iriven\Fluxon\Tests;

use Iriven\Fluxon\Application\Runtime\AsyncRuntimeDispatcher;
use PHPUnit\Framework\TestCase;

final class AsyncRuntimeDispatcherTest extends TestCase
{
    public function testDispatcherQueuesStructuredAsyncJob(): void
    {
        $dispatcher = new AsyncRuntimeDispatcher();
        $result = $dispatcher->dispatch('submit', 'contact', ['email' => 'john@example.com']);

        self::assertSame('queue', $result['transport']);
        self::assertSame('queued', $result['status']);
        self::assertSame(1, $dispatcher->transport()->size());
    }
}
