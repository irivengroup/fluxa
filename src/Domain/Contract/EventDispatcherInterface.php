<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Contract;

interface EventDispatcherInterface
{
    public function addListener(string $eventName, callable $listener): void;

    public function addSubscriber(EventSubscriberInterface $subscriber): void;

    public function dispatch(string $eventName, object $event): object;
}
