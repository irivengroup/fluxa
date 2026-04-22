<?php
declare(strict_types=1);

namespace Iriven\Fluxon\Tests;

use Iriven\Fluxon\Application\Runtime\AsyncJobEnvelope;
use Iriven\Fluxon\Application\Runtime\ExecutionContext;
use PHPUnit\Framework\TestCase;

final class AsyncJobEnvelopeTest extends TestCase
{
    public function testEnvelopeCanBeConvertedToArray(): void
    {
        $job = new AsyncJobEnvelope(
            'job-1',
            'submit',
            'contact',
            ['email' => 'john@example.com'],
            new ExecutionContext('req-1', '2026-01-01T00:00:00+00:00', 'test')
        );

        $data = $job->toArray();

        self::assertSame('job-1', $data['job_id']);
        self::assertSame('submit', $data['action']);
        self::assertSame('contact', $data['form_name']);
    }
}
