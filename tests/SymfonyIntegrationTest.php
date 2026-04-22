<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Integration\Symfony\SymfonyFormBridge;
use PHPUnit\Framework\TestCase;

final class SymfonyIntegrationTest extends TestCase
{
    public function testSymfonyBridgeCanCreateForm(): void
    {
        $form = (new SymfonyFormBridge())->create('contact');
        self::assertSame('contact', $form->getName());
    }
}
