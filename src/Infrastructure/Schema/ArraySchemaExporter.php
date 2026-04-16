<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Infrastructure\Schema;

use Iriven\PhpFormGenerator\Domain\Contract\SchemaExporterInterface;
use Iriven\PhpFormGenerator\Domain\Form\FieldConfig;
use Iriven\PhpFormGenerator\Domain\Form\Form;
use Iriven\PhpFormGenerator\Infrastructure\Type\TypeResolver;

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
            'action' => $form->options()['action'] ?? null,
            'fields' => $fields,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function exportField(FieldConfig $field): array
    {
        $children = [];
        foreach ($field->children as $name => $child) {
            $children[$name] = $this->exportField($child);
        }

        $entryType = $field->entryType;
        if (is_string($entryType) && $entryType !== '') {
            $entryType = TypeResolver::resolveFieldType($entryType);
        }

        return [
            'type' => TypeResolver::resolveFieldType($field->typeClass),
            'label' => $field->options['label'] ?? null,
            'required' => (bool) ($field->options['required'] ?? false),
            'help' => $field->options['help'] ?? null,
            'placeholder' => is_array($field->options['attr'] ?? null) ? ($field->options['attr']['placeholder'] ?? null) : null,
            'default' => $field->options['data'] ?? null,
            'choices' => is_array($field->options['choices'] ?? null) ? $field->options['choices'] : [],
            'constraints' => array_map(
                static fn (object $constraint): string => $constraint::class,
                $field->constraints
            ),
            'compound' => $field->compound,
            'collection' => $field->collection,
            'entry_type' => $entryType,
            'entry_options' => $field->entryOptions,
            'children' => $children,
        ];
    }
}
