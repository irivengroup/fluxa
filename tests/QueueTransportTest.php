<?php
declare(strict_types=1);

namespace Iriven\Fluxon\Tests;

use Iriven\Fluxon\Application\Runtime\QueueTransport;
use PHPUnit\Framework\TestCase;

final class QueueTransportTest extends TestCase
{
    public function testQueueTransportQueuesPayload(): void
    {
        $transport = new QueueTransport();
        $result = $transport->send(['a' => 1]);

        self::assertSame('queue', $result['transport']);
        self::assertSame('queued', $result['status']);
        self::assertSame(1, $transport->size());
    }
}
