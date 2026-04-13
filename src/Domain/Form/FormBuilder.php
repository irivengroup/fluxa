<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Form;

use Iriven\PhpFormGenerator\Domain\Contract\ConstraintInterface;
use Iriven\PhpFormGenerator\Domain\Contract\CsrfManagerInterface;
use Iriven\PhpFormGenerator\Domain\Contract\DataMapperInterface;
use Iriven\PhpFormGenerator\Domain\Contract\FieldTypeInterface;
use Iriven\PhpFormGenerator\Domain\Contract\FormBuilderInterface;
use Iriven\PhpFormGenerator\Domain\Event\EventDispatcher;

final class FormBuilder implements FormBuilderInterface
{
    /**
     * @var array<string, Field>
     */
    private array $fields = [];

    /**
     * @var list<ConstraintInterface>
     */
    private array $formConstraints = [];

    /**
     * @var list<array{key:string, legend:?string, description:?string, attr:array<string, mixed>}>
     */
    private array $fieldsetStack = [];

    /**
     * @var array<string, mixed>
     */
    private array $fieldsetTree = [];

    private int $fieldsetCounter = 0;

    private mixed $data = [];

    public function __construct(
        private readonly string $name,
        private readonly DataMapperInterface $dataMapper,
        private readonly ?CsrfManagerInterface $csrfManager,
        private readonly EventDispatcher $eventDispatcher,
        private readonly array $formOptions = [],
    ) {
    }

    public function add(string $name, string $type, array $options = []): self
    {
        /** @var FieldTypeInterface $instance */
        $instance = new $type();
        $resolved = $instance->configureOptions($options);

        if ($this->fieldsetStack !== [] && !isset($resolved['fieldset_path'])) {
            $resolved['fieldset_path'] = $this->fieldsetStack;
        }

        $field = new Field($name, $instance, $resolved);
        $instance->buildField($field, $resolved);
        $this->fields[$name] = $field;

        return $this;
    }

    public function remove(string $name): self
    {
        unset($this->fields[$name]);
        return $this;
    }

    public function setData(mixed $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function addEventListener(string $eventName, callable $listener): self
    {
        $this->eventDispatcher->addListener($eventName, $listener);
        return $this;
    }

    public function addFormConstraint(ConstraintInterface $constraint): self
    {
        $this->formConstraints[] = $constraint;
        return $this;
    }

    public function addFieldset(array $options = []): self
    {
        $this->fieldsetCounter++;

        $definition = [
            'key' => (string) ($options['key'] ?? 'fieldset_' . $this->fieldsetCounter),
            'legend' => isset($options['legend']) ? (string) $options['legend'] : null,
            'description' => isset($options['description']) ? (string) $options['description'] : null,
            'attr' => (array) ($options['attr'] ?? []),
        ];

        $this->registerFieldset($definition);
        $this->fieldsetStack[] = $definition;

        return $this;
    }

    public function endFieldset(): self
    {
        array_pop($this->fieldsetStack);
        return $this;
    }

    public function getForm(): FormInterface
    {
        $config = new FormConfig(
            name: $this->name,
            method: strtoupper((string) ($this->formOptions['method'] ?? 'POST')),
            action: (string) ($this->formOptions['action'] ?? ''),
            csrfProtection: (bool) ($this->formOptions['csrf_protection'] ?? true),
            csrfFieldName: (string) ($this->formOptions['csrf_field_name'] ?? '_token'),
            csrfTokenId: (string) ($this->formOptions['csrf_token_id'] ?? $this->name),
            allowExtraFields: (bool) ($this->formOptions['allow_extra_fields'] ?? false),
            attr: (array) ($this->formOptions['attr'] ?? []),
            dataClass: isset($this->formOptions['data_class']) ? (string) $this->formOptions['data_class'] : null,
        );

        return new Form(
            config: $config,
            fields: $this->fields,
            dataMapper: $this->dataMapper,
            csrfManager: $this->csrfManager,
            eventDispatcher: $this->eventDispatcher,
            formConstraints: $this->formConstraints,
            data: $this->data,
            fieldsets: $this->fieldsetTree,
        );
    }

    /**
     * @param array{key:string, legend:?string, description:?string, attr:array<string, mixed>} $definition
     */
    private function registerFieldset(array $definition): void
    {
        $container =& $this->fieldsetTree;

        foreach ($this->fieldsetStack as $parent) {
            $parentKey = $parent['key'];
            if (!isset($container[$parentKey])) {
                $container[$parentKey] = $parent + ['children' => []];
            }

            if (!isset($container[$parentKey]['children']) || !is_array($container[$parentKey]['children'])) {
                $container[$parentKey]['children'] = [];
            }

            $container =& $container[$parentKey]['children'];
        }

        if (!isset($container[$definition['key']])) {
            $container[$definition['key']] = $definition + ['children' => []];
        }
    }
}
