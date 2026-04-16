<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Infrastructure\Schema;

use Iriven\PhpFormGenerator\Domain\Contract\SchemaExporterInterface;
use Iriven\PhpFormGenerator\Domain\Form\Form;
use Iriven\PhpFormGenerator\Domain\Form\FieldConfig;

final class ArraySchemaExporter implements SchemaExporterInterface
{
    /**
     * @return array<string, mixed>
     */
    public function export(Form $form): array
    {
        $fields = [];

        foreach ($form->fields() as $name => $field) {
            $fields[$name] = $this->exportField($field);
        }

        return [
            'name' => $form->getName(),
            'method' => (string) ($form->options()['method'] ?? 'POST'),
            'fields' => $fields,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function exportField(FieldConfig $field): array
    {
        return [
            'type' => $field->typeClass,
            'label' => $field->options['label'] ?? null,
            'required' => (bool) ($field->options['required'] ?? false),
            'choices' => is_array($field->options['choices'] ?? null) ? $field->options['choices'] : [],
            'constraints' => array_map(
                static fn (object $constraint): string => $constraint::class,
                $field->constraints
            ),
            'compound' => $field->compound,
            'collection' => $field->collection,
        ];
    }
}
