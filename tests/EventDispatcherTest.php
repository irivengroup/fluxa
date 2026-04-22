<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\Events\FormBuildEvent;
use Iriven\Fluxa\Application\Events\InMemoryEventDispatcher;
use Iriven\Fluxa\Application\FormFactory;
use PHPUnit\Framework\TestCase;

final class EventDispatcherTest extends TestCase
{
    public function testListenersRunInRegistrationOrder(): void
    {
        $dispatcher = new InMemoryEventDispatcher();
        $calls = [];

        $dispatcher->addListener(function () use (&$calls): void { $calls[] = 'a'; });
        $dispatcher->addListener(function () use (&$calls): void { $calls[] = 'b'; });

        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $dispatcher->dispatch(new FormBuildEvent($form));

        self::assertSame(['a', 'b'], $calls);
    }
}
