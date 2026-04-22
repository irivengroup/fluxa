<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Contract;

interface FormExtensionInterface
{
    /**
     * @param array<string, mixed> $options
     * @return array<string, mixed>
     */
    public function extendFormOptions(array $options): array;
}
