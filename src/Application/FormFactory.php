<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Application;

use Iriven\PhpFormGenerator\Domain\Contract\CsrfManagerInterface;
use Iriven\PhpFormGenerator\Domain\Contract\EventDispatcherInterface;
use Iriven\PhpFormGenerator\Domain\Contract\FormTypeInterface;
use Iriven\PhpFormGenerator\Domain\Form\Form;
use Iriven\PhpFormGenerator\Domain\Form\FormBuilder;
use Iriven\PhpFormGenerator\Infrastructure\Event\EventDispatcher;
use Iriven\PhpFormGenerator\Infrastructure\Options\OptionsResolver;
use Iriven\PhpFormGenerator\Infrastructure\Security\NullCsrfManager;

final class FormFactory
{
    public function __construct(
        private readonly ?CsrfManagerInterface $csrfManager = null,
        private readonly ?EventDispatcherInterface $eventDispatcher = null,
    ) {
    }

    public function createBuilder(string $name = 'form', mixed $data = null, array $options = []): FormBuilder
    {
        $options['csrf_manager'] = $options['csrf_manager'] ?? $this->csrfManager ?? new NullCsrfManager();
        $options['event_dispatcher'] = $options['event_dispatcher'] ?? $this->eventDispatcher ?? new EventDispatcher();

        return new FormBuilder($name, $data, $options);
    }

    /** @param class-string<FormTypeInterface> $typeClass */
    public function create(string $typeClass, mixed $data = null, array $options = []): Form
    {
        $builder = $this->createBuilder($options['name'] ?? 'form', $data, $options);
        $type = new $typeClass();
        $resolver = new OptionsResolver();
        $type->configureOptions($resolver);
        $resolved = $resolver->resolve($options);
        $type->buildForm($builder, $resolved);

        return $builder->getForm();
    }
}
