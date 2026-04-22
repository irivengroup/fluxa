<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Contract;

/**
 * @api
 */
interface FieldExtensionInterface
{
    public function supports(string $type): bool;

    /**
     * @param array<string, mixed> $config
     * @return array<string, mixed>
     */
    public function apply(array $config): array;
}
