<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Form;

final class FormView
{
    /** @param list<FormView> $children */
    /** @param list<string> $errors */
    /** @param list<Fieldset> $fieldsets */
    public function __construct(
        public string $name,
        public string $fullName,
        public string $id,
        public string $type,
        public mixed $value,
        public array $vars = [],
        public array $children = [],
        public array $errors = [],
        public array $fieldsets = [],
        public bool $submitted = false,
        public bool $valid = true,
    ) {
    }
}
