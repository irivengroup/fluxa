<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Infrastructure\Translation;

interface TranslatorInterface
{
    /**
     * @param array<string, scalar|null> $parameters
     */
    public function trans(string $key, array $parameters = []): string;
}
