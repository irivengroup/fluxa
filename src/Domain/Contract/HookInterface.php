<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Contract;

interface HookInterface
{
    public static function getName(): string;
}
