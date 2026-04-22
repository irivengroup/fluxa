<?php
declare(strict_types=1);

namespace Iriven\Fluxon\Tests;

use Iriven\Fluxon\Application\Runtime\AsyncJobEnvelope;
use Iriven\Fluxon\Application\Runtime\ExecutionContext;
use Iriven\Fluxon\Application\Runtime\JobSerializer;
use PHPUnit\Framework\TestCase;

final class JobSerializerTest extends TestCase
{
    public function testJobRoundTripIsStable(): void
    {
        $serializer = new JobSerializer();
        $job = new AsyncJobEnvelope(
            'job-1',
            'submit',
            'contact',
            ['email' => 'john@example.com'],
            new ExecutionContext('req-1', '2026-01-01T00:00:00+00:00', 'test')
        );

        $encoded = $serializer->serialize($job);
        $decoded = $serializer->deserialize($encoded);

        self::assertSame('job-1', $decoded->jobId());
        self::assertSame('submit', $decoded->action());
        self::assertSame('contact', $decoded->formName());
    }
}
