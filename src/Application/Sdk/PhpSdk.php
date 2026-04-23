<?php
declare(strict_types=1);

namespace Iriven\Fluxon\Application\Sdk;

final class PhpSdk
{
    public function build(array $schema): array
    {
        return [
            'sdk' => 'php',
            'schema' => $schema,
        ];
    }
}
