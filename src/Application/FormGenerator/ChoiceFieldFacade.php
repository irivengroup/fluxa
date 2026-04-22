<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Application\FormGenerator;

use Iriven\Fluxa\Domain\Field\CheckboxType;
use Iriven\Fluxa\Domain\Field\DatalistType;
use Iriven\Fluxa\Domain\Field\RadioType;
use Iriven\Fluxa\Domain\Field\SelectType;
use Iriven\Fluxa\Domain\Field\YesNoType;

final class ChoiceFieldFacade
{
    public function __construct(private readonly BasicFieldFacade $basicFields)
    {
    }

    /**
     * @param array<string, mixed> $choices
     * @param array<string, mixed> $attributes
     */
    public function addRadio(string $name, array $choices = [], array $attributes = []): void
    {
        $this->addChoiceField($name, RadioType::class, $choices, $attributes);
    }

    /**
     * @param array<string, mixed> $choices
     * @param array<string, mixed> $attributes
     */
    public function addCheckbox(string $name, array $choices = [], array $attributes = []): void
    {
        $this->addChoiceField($name, CheckboxType::class, $choices, $attributes);
    }

    /**
     * @param array<string, mixed> $choices
     * @param array<string, mixed> $attributes
     */
    public function addSelect(string $name, array $choices = [], array $attributes = []): void
    {
        $this->addChoiceField($name, SelectType::class, $choices, $attributes);
    }

    /** @param array<string, mixed> $attributes */
    public function addYesNo(string $name, array $attributes = []): void
    {
        $this->basicFields->add($name, YesNoType::class, $attributes);
    }

    /**
     * @param array<string, mixed> $choices
     * @param array<string, mixed> $attributes
     */
    public function addDatalist(string $name, array $choices = [], array $attributes = []): void
    {
        $this->addChoiceField($name, DatalistType::class, $choices, $attributes);
    }

    /**
     * @param array<string, mixed> $choices
     * @param array<string, mixed> $attributes
     */
    private function addChoiceField(string $name, string $typeClass, array $choices, array $attributes): void
    {
        if ($choices !== []) {
            $attributes['choices'] = $choices;
        }

        $this->basicFields->add($name, $typeClass, $attributes);
    }
}
