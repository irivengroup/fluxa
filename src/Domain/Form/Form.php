<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Form;

use Iriven\PhpFormGenerator\Domain\Contract\RequestInterface;
use Iriven\PhpFormGenerator\Domain\Transformer\BooleanTransformer;
use Iriven\PhpFormGenerator\Domain\Validation\Validator;
use Iriven\PhpFormGenerator\Infrastructure\Mapping\ArrayDataMapper;
use Iriven\PhpFormGenerator\Infrastructure\Mapping\ObjectDataMapper;

final class Form
{
    private bool $submitted = false;
    private bool $valid = true;

    /** @var array<string, mixed> */
    private array $values = [];

    /** @var array<string, list<string>> */
    private array $errors = [];

    public function __construct(
        private readonly string $name,
        /** @var array<string, FieldConfig> */
        private readonly array $fields,
        private mixed $data = null,
        private readonly array $options = [],
        /** @var list<Fieldset> */
        private readonly array $fieldsets = [],
    ) {
        $this->initializeValues();
    }

    private function initializeValues(): void
    {
        foreach ($this->fields as $name => $field) {
            if ($field->collection) {
                $this->values[$name] = is_array($this->readDataValue($name)) ? $this->readDataValue($name) : [];
                continue;
            }
            if ($field->compound) {
                $this->values[$name] = is_array($this->readDataValue($name)) ? $this->readDataValue($name) : [];
                continue;
            }
            $value = $this->readDataValue($name);
            foreach ($field->transformers as $transformer) {
                $value = $transformer->transform($value);
            }
            $this->values[$name] = $value;
        }
    }

    private function readDataValue(string $name): mixed
    {
        if (is_array($this->data)) {
            return $this->data[$name] ?? ($this->fields[$name]->options['data'] ?? null);
        }
        if (is_object($this->data) && isset($this->data->{$name})) {
            return $this->data->{$name};
        }
        return $this->fields[$name]->options['data'] ?? null;
    }

    public function handleRequest(RequestInterface $request): void
    {
        $payload = $request->get($this->name, []);
        if (!is_array($payload)) {
            return;
        }
        $this->submitted = true;
        $validator = new Validator();

        foreach ($this->fields as $name => $field) {
            $raw = $payload[$name] ?? null;

            if ($field->collection) {
                $items = [];
                if (is_array($raw)) {
                    foreach ($raw as $row) {
                        $items[] = $this->submitEntry($field, is_array($row) ? $row : []);
                    }
                }
                $this->values[$name] = $items;
                continue;
            }

            if ($field->compound) {
                $this->values[$name] = $this->submitCompound($field, is_array($raw) ? $raw : []);
                continue;
            }

            if (($field->typeClass === 'Iriven\\PhpFormGenerator\\Domain\\Field\\CheckboxType') && $raw === null) {
                $raw = false;
            }

            $value = $raw;
            foreach ($field->transformers as $transformer) {
                $value = $transformer->reverseTransform($value);
            }
            $this->values[$name] = $value;
            $this->errors[$name] = $validator->validate($value, $field->constraints);
        }

        foreach ($this->errors as $messages) {
            if ($messages !== []) {
                $this->valid = false;
                break;
            }
        }

        if ($this->valid) {
            $this->mapData();
        }
    }

    private function submitCompound(FieldConfig $field, array $raw): array
    {
        $result = [];
        foreach ($field->children as $childName => $child) {
            $value = $raw[$childName] ?? null;
            foreach ($child->transformers as $transformer) {
                $value = $transformer->reverseTransform($value);
            }
            $result[$childName] = $value;
            $messages = (new Validator())->validate($value, $child->constraints);
            if ($messages !== []) {
                $this->errors[$field->name . '.' . $childName] = $messages;
                $this->valid = false;
            }
        }
        return $result;
    }

    private function submitEntry(FieldConfig $field, array $row): array
    {
        $entryType = $field->entryType;
        if ($entryType === null) {
            return $row;
        }

        if (class_exists($entryType) && method_exists($entryType, 'buildForm')) {
            $builder = new FormBuilder($field->name . '_entry');
            $entry = new $entryType();
            $entry->buildForm($builder, $field->entryOptions);
            $result = [];
            foreach ($builder->all() as $childName => $child) {
                $value = $row[$childName] ?? null;
                foreach ($child->transformers as $transformer) {
                    $value = $transformer->reverseTransform($value);
                }
                $result[$childName] = $value;
                $messages = (new Validator())->validate($value, $child->constraints);
                if ($messages !== []) {
                    $this->errors[$field->name . '[]' . '.' . $childName] = $messages;
                    $this->valid = false;
                }
            }
            return $result;
        }

        return $row;
    }

    private function mapData(): void
    {
        if (is_array($this->data) || $this->data === null) {
            $mapper = new ArrayDataMapper();
            $this->data = $mapper->map($this->data ?? [], $this->values);
            return;
        }

        if (is_object($this->data)) {
            $mapper = new ObjectDataMapper();
            $this->data = $mapper->map($this->data, $this->values);
        }
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function isSubmitted(): bool
    {
        return $this->submitted;
    }

    public function isValid(): bool
    {
        return $this->submitted && $this->valid;
    }

    /** @return array<string, list<string>> */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function createView(): FormView
    {
        $children = [];
        foreach ($this->fields as $name => $field) {
            $fullName = $this->name . '[' . $name . ']';
            $children[] = $this->createFieldView($name, $field, $fullName, 'form_' . $name, $this->values[$name] ?? null);
        }

        return new FormView(
            $this->name,
            $this->name,
            $this->name,
            'form',
            null,
            ['method' => strtoupper((string) ($this->options['method'] ?? 'POST')), 'action' => (string) ($this->options['action'] ?? '')],
            $children,
            [],
            $this->fieldsets,
            $this->submitted,
            $this->valid,
        );
    }

    private function createFieldView(string $name, FieldConfig $field, string $fullName, string $id, mixed $value): FormView
    {
        $vars = $field->options;
        $vars['label'] = $field->options['label'] ?? ucfirst($name);
        $vars['attr'] = $field->options['attr'] ?? [];
        $vars['type_class'] = $field->typeClass;

        if ($field->collection) {
            $children = [];
            if (is_array($value)) {
                foreach ($value as $index => $row) {
                    $entryChildren = [];
                    if ($field->entryType !== null) {
                        $builder = new FormBuilder($name . '_entry');
                        $entry = new ($field->entryType)();
                        $entry->buildForm($builder, $field->entryOptions);
                        foreach ($builder->all() as $childName => $child) {
                            $entryChildren[] = $this->createFieldView(
                                $childName,
                                $child,
                                $fullName . '[' . $index . ']' . '[' . $childName . ']',
                                $id . '_' . $index . '_' . $childName,
                                $row[$childName] ?? null,
                            );
                        }
                    }
                    $children[] = new FormView((string) $index, $fullName . '[' . $index . ']', $id . '_' . $index, 'collection_entry', $row, [], $entryChildren, []);
                }
            }
            return new FormView($name, $fullName, $id, 'collection', $value, $vars, $children, $this->errors[$name] ?? []);
        }

        if ($field->compound) {
            $children = [];
            foreach ($field->children as $childName => $child) {
                $children[] = $this->createFieldView(
                    $childName,
                    $child,
                    $fullName . '[' . $childName . ']',
                    $id . '_' . $childName,
                    is_array($value) ? ($value[$childName] ?? null) : null,
                );
            }
            return new FormView($name, $fullName, $id, 'compound', $value, $vars, $children, $this->errors[$name] ?? []);
        }

        return new FormView($name, $fullName, $id, $field->typeClass, $value, $vars, [], $this->errors[$name] ?? []);
    }
}
