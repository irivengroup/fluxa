<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Form;

use Iriven\PhpFormGenerator\Domain\Contract\FormTypeInterface;
use Iriven\PhpFormGenerator\Domain\Field\CollectionType;

final class FormBuilder
{
    /** @var array<string, FieldConfig> */
    private array $fields = [];

    /** @var list<Fieldset> */
    private array $fieldsets = [];

    /** @var list<string> */
    private array $fieldsetStack = [];

    public function __construct(
        private readonly string $name = 'form',
        private mixed $data = null,
        private array $options = [],
    ) {
    }

    public function add(string $name, string $typeClass, array $options = []): self
    {
        $constraints = $options['constraints'] ?? [];
        $transformers = $options['transformers'] ?? [];
        if (method_exists($typeClass, 'defaultTransformers')) {
            $transformers = array_merge($typeClass::defaultTransformers(), $transformers);
        }
        unset($options['constraints'], $options['transformers']);

        $compound = false;
        $collection = false;
        $children = [];
        $entryType = null;
        $entryOptions = [];

        if (is_subclass_of($typeClass, FormTypeInterface::class)) {
            $subBuilder = new self($name, null, $options);
            /** @var FormTypeInterface $type */
            $type = new $typeClass();
            $type->buildForm($subBuilder, $options);
            $compound = true;
            $children = $subBuilder->all();
        }

        if ($typeClass === CollectionType::class) {
            $collection = true;
            $compound = true;
            $entryType = $options['entry_type'] ?? null;
            $entryOptions = $options['entry_options'] ?? [];
        }

        $config = new FieldConfig(
            $name,
            $typeClass,
            $options,
            $constraints,
            $transformers,
            $children,
            $compound,
            $collection,
            $entryType,
            $entryOptions,
            [],
        );

        $this->fields[$name] = $config;

        if ($this->fieldsetStack !== []) {
            $fieldsetId = end($this->fieldsetStack);
            foreach ($this->fieldsets as $fieldset) {
                if ($fieldset->id === $fieldsetId) {
                    $fieldset->fields[] = $name;
                    break;
                }
            }
        }

        return $this;
    }

    public function addFieldset(array $options = []): self
    {
        $id = 'fs_' . (count($this->fieldsets) + 1) . '_' . substr(md5((string) microtime(true)), 0, 6);
        $this->fieldsets[] = new Fieldset($id, $options, []);
        $this->fieldsetStack[] = $id;
        return $this;
    }

    public function endFieldset(): self
    {
        array_pop($this->fieldsetStack);
        return $this;
    }

    /** @return array<string, FieldConfig> */
    public function all(): array
    {
        return $this->fields;
    }

    /** @return list<Fieldset> */
    public function fieldsets(): array
    {
        return $this->fieldsets;
    }

    public function getForm(): Form
    {
        return new Form($this->name, $this->fields, $this->data, $this->options, $this->fieldsets);
    }
}
