<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Contract;

interface EventSubscriberInterface
{
    /** @return array<string, string> */
    public static function getSubscribedEvents(): array;
}
