<?php
declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests;

use Iriven\PhpFormGenerator\Integration\Laravel\LaravelFormBridge;
use PHPUnit\Framework\TestCase;

final class LaravelIntegrationTest extends TestCase
{
    public function testLaravelBridgeCanCreateForm(): void
    {
        $form = (new LaravelFormBridge())->make('contact');
        self::assertSame('contact', $form->getName());
    }
}
