<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Application;

use Iriven\Fluxa\Domain\Contract\CaptchaManagerInterface;
use Iriven\Fluxa\Domain\Contract\CsrfManagerInterface;
use Iriven\Fluxa\Domain\Contract\EventDispatcherInterface;
use Iriven\Fluxa\Domain\Form\Form;
use Iriven\Fluxa\Domain\Form\FormBuilder;
use Iriven\Fluxa\Infrastructure\Event\EventDispatcher;
use Iriven\Fluxa\Infrastructure\Extension\ExtensionRegistry;
use Iriven\Fluxa\Infrastructure\Options\OptionsResolver;
use Iriven\Fluxa\Infrastructure\Security\NullCsrfManager;
use Iriven\Fluxa\Infrastructure\Security\SessionCaptchaManager;
use Iriven\Fluxa\Infrastructure\Security\SessionCsrfManager;
use Iriven\Fluxa\Infrastructure\Type\TypeResolver;

final class FormFactory
{
    public function __construct(
        private readonly ?CsrfManagerInterface $csrfManager = null,
        private readonly ?EventDispatcherInterface $eventDispatcher = null,
        private readonly ?CaptchaManagerInterface $captchaManager = null,
        private readonly ?ExtensionRegistry $extensionRegistry = null,
        private readonly ?FormPluginKernel $pluginKernel = null,
        private readonly ?FormHookKernel $hookKernel = null,
    ) {
        $this->pluginKernel?->plugins();
    }

    /** @param array<string, mixed> $options */
    public function createBuilder(string $name = 'form', mixed $data = null, array $options = []): FormBuilder
    {
        $options['csrf_manager'] = $options['csrf_manager'] ?? $this->csrfManager ?? (($options['csrf_protection'] ?? true) === true ? new SessionCsrfManager() : new NullCsrfManager());
        $options['event_dispatcher'] = $options['event_dispatcher'] ?? $this->eventDispatcher ?? new EventDispatcher();
        $options['captcha_manager'] = $options['captcha_manager'] ?? $this->captchaManager ?? new SessionCaptchaManager();
        $options['csrf_protection'] = $options['csrf_protection'] ?? true;
        $options['extension_registry'] = $options['extension_registry'] ?? $this->resolvedExtensionRegistry();
        $options['hook_kernel'] = $options['hook_kernel'] ?? $this->hookKernel;

        return new FormBuilder($name, $data, $options);
    }

    /**
     * @param string $typeClass
     * @param array<string, mixed> $options
     */
    public function create(string $typeClass, mixed $data = null, array $options = []): Form
    {
        $builder = $this->createBuilder((string) ($options['name'] ?? 'form'), $data, $options);
        $typeClass = TypeResolver::resolveFormType($typeClass);
        $type = new $typeClass();
        $resolver = new OptionsResolver();
        $type->configureOptions($resolver);
        $resolved = $resolver->resolve($options);
        $type->buildForm($builder, $resolved);

        return $builder->getForm();
    }

    private function resolvedExtensionRegistry(): ExtensionRegistry
    {
        if ($this->extensionRegistry instanceof ExtensionRegistry) {
            return $this->extensionRegistry;
        }

        if ($this->pluginKernel instanceof FormPluginKernel) {
            return $this->pluginKernel->extensions();
        }

        return new ExtensionRegistry();
    }
}
