<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Contract;

interface ValidationGroupAwareInterface
{
    /**
     * @return list<string>
     */
    public function groups(): array;
}
