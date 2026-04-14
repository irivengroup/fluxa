<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Contract;

interface OptionsResolverInterface
{
    public function setDefaults(array $defaults): self;

    public function setRequired(array $required): self;

    public function setAllowedTypes(string $option, string|array $types): self;

    public function setAllowedValues(string $option, callable|array $values): self;

    public function resolve(array $options = []): array;
}
