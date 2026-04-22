<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Application\Mapping;

/** @api */
final class PropertyPathNormalizer
{
    public function normalize(string $name): string
    {
        return trim($name) !== '' ? trim($name) : $name;
    }
}
