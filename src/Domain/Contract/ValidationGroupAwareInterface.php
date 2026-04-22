<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Contract;

interface ValidationGroupAwareInterface
{
    /**
     * @return array<int, string>
     */
    public function groups(): array;
}
