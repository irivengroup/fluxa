<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use ArrayObject;
use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\Runtime\PrioritizedHookKernel;
use PHPUnit\Framework\TestCase;

final class PrioritizedHookKernelTest extends TestCase
{
    public function testHooksRunInDescendingPriorityOrder(): void
    {
        $captured = new ArrayObject();
        $form = (new FormFactory())->createBuilder('contact')->getForm();

        $kernel = new PrioritizedHookKernel();
        $kernel->register(new class($captured) implements \Iriven\Fluxa\Domain\Contract\FormHookInterface {
            /** @param ArrayObject<int, string> $captured */
            public function __construct(private ArrayObject $captured) {}
            public static function getName(): string { return 'before_render'; }
            public function __invoke(\Iriven\Fluxa\Domain\Form\Form $form, array $context = []): void { $this->captured->append('low'); }
        }, 10);
        $kernel->register(new class($captured) implements \Iriven\Fluxa\Domain\Contract\FormHookInterface {
            /** @param ArrayObject<int, string> $captured */
            public function __construct(private ArrayObject $captured) {}
            public static function getName(): string { return 'before_render'; }
            public function __invoke(\Iriven\Fluxa\Domain\Form\Form $form, array $context = []): void { $this->captured->append('high'); }
        }, 100);

        $kernel->dispatch('before_render', $form);

        self::assertSame(['high', 'low'], $captured->getArrayCopy());
    }
}
