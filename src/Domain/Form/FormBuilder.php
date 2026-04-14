<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Form;

use Iriven\PhpFormGenerator\Domain\Contract\ConstraintInterface;
use Iriven\PhpFormGenerator\Domain\Contract\EventDispatcherInterface;
use Iriven\PhpFormGenerator\Domain\Contract\EventSubscriberInterface;
use Iriven\PhpFormGenerator\Domain\Contract\FormTypeInterface;
use Iriven\PhpFormGenerator\Domain\Field\CollectionType;
use Iriven\PhpFormGenerator\Infrastructure\Event\EventDispatcher;
use Iriven\PhpFormGenerator\Infrastructure\Options\OptionsResolver;
use Iriven\PhpFormGenerator\Infrastructure\Security\NullCsrfManager;

final class FormBuilder
{
    /** @var array<string, FieldConfig> */
    private array $fields = [];

    /** @var list<Fieldset> */
    private array $fieldsets = [];

    /** @var list<string> */
    private array $fieldsetStack = [];

    /** @var list<ConstraintInterface> */
    private array $formConstraints = [];

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        private readonly string $name = 'form',
        private mixed $data = null,
        private array $options = [],
    ) {
        $this->eventDispatcher = $this->options['event_dispatcher'] ?? new EventDispatcher();
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
            $subBuilder = new self($name, null, $options + ['event_dispatcher' => $this->eventDispatcher]);
            $type = new $typeClass();
            $resolver = new OptionsResolver();
            $type->configureOptions($resolver);
            $resolved = $resolver->resolve($options);
            $type->buildForm($subBuilder, $resolved);
            $compound = true;
            $children = $subBuilder->all();
            $options = $resolved;
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
            $currentId = $this->fieldsetStack[array_key_last($this->fieldsetStack)];
            foreach ($this->fieldsets as $fieldset) {
                if ($fieldset->id === $currentId) {
                    $fieldset->fields[] = $name;
                    break;
                }
            }
        }

        return $this;
    }

    public function addFieldset(array $options = []): self
    {
        $fieldset = new Fieldset('fs_' . (count($this->fieldsets) + 1), $options, []);

        if ($this->fieldsetStack !== []) {
            $parentId = $this->fieldsetStack[array_key_last($this->fieldsetStack)];
            foreach ($this->fieldsets as $existing) {
                if ($existing->id === $parentId) {
                    $existing->children[] = $fieldset;
                    break;
                }
            }
        } else {
            $this->fieldsets[] = $fieldset;
        }

        $this->fieldsetStack[] = $fieldset->id;

        return $this;
    }

    public function endFieldset(): self
    {
        array_pop($this->fieldsetStack);
        return $this;
    }

    public function addFormConstraint(ConstraintInterface $constraint): self
    {
        $this->formConstraints[] = $constraint;
        return $this;
    }

    public function addEventListener(string $eventName, callable $listener): self
    {
        $this->eventDispatcher->addListener($eventName, $listener);
        return $this;
    }

    public function addEventSubscriber(EventSubscriberInterface $subscriber): self
    {
        $this->eventDispatcher->addSubscriber($subscriber);
        return $this;
    }

    /** @return array<string, FieldConfig> */
    public function all(): array
    {
        return $this->fields;
    }

    public function getForm(): Form
    {
        $options = $this->options + [
            'method' => 'POST',
            'action' => '',
            'csrf_protection' => false,
            'csrf_field_name' => '_token',
            'csrf_token_id' => $this->name,
            'csrf_manager' => new NullCsrfManager(),
            'event_dispatcher' => $this->eventDispatcher,
        ];

        return new Form(
            $this->name,
            $this->fields,
            $this->data,
            $options,
            $this->fieldsets,
            $this->eventDispatcher,
            $this->formConstraints,
        );
    }
}
