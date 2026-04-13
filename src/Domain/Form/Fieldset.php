<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Form;

final class Fieldset
{
    public function __construct(
        public string $id,
        public array $options,
        public array $fields = [],
    ) {
    }
}
