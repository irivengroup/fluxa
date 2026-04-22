<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Form;

use Iriven\Fluxa\Domain\Contract\EventDispatcherInterface;
use Iriven\Fluxa\Infrastructure\Extension\ExtensionRegistry;
use Iriven\Fluxa\Infrastructure\Security\NullCsrfManager;
use Iriven\Fluxa\Infrastructure\Security\SessionCsrfManager;

final class FormBuilderFormFactory
{
    public function __construct(private readonly ExtensionRegistry $extensionRegistry)
    {
    }

    /**
     * @param array<string, mixed> $options
     * @param array<string, FieldConfig> $fields
     * @param array<int, Fieldset> $fieldsets
     * @param array<int, \Iriven\Fluxa\Domain\Contract\ConstraintInterface> $formConstraints
     */
    public function create(
        string $name,
        array $options,
        array $fields,
        EventDispatcherInterface $eventDispatcher,
        mixed $data,
        array $fieldsets,
        array $formConstraints
    ): Form {
        $options = $options + [
            'method' => 'POST',
            'action' => '',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => $name,
            'event_dispatcher' => $eventDispatcher,
        ];

        if (!array_key_exists('csrf_manager', $options)) {
            $options['csrf_manager'] = ($options['csrf_protection'] ?? true) === true
                ? new SessionCsrfManager()
                : new NullCsrfManager();
        }

        foreach ($this->extensionRegistry->formExtensions() as $extension) {
            $options = $extension->extendFormOptions($options);
        }

        return new Form(
            $name,
            $fields,
            $eventDispatcher,
            $options,
            $data,
            $fieldsets,
            $formConstraints,
        );
    }
}
