<?php
declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests;

use Iriven\PhpFormGenerator\Integration\Symfony\SymfonyFormBridge;
use PHPUnit\Framework\TestCase;

final class SymfonyIntegrationTest extends TestCase
{
    public function testSymfonyBridgeCanCreateForm(): void
    {
        $form = (new SymfonyFormBridge())->create('contact');
        self::assertSame('contact', $form->getName());
    }
}
