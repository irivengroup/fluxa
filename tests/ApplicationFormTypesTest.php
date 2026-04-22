<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormGenerator;
use Iriven\Fluxa\Application\FormType\ContactType;
use Iriven\Fluxa\Application\FormType\InvoiceType;
use Iriven\Fluxa\Application\FormType\RegistrationType;
use PHPUnit\Framework\TestCase;

final class ApplicationFormTypesTest extends TestCase
{
    public function testApplicationFormTypesExist(): void
    {
        self::assertTrue(class_exists(ContactType::class));
        self::assertTrue(class_exists(InvoiceType::class));
        self::assertTrue(class_exists(RegistrationType::class));
    }

    public function testFactoryUsesCsrfProtectionByDefault(): void
    {
        $form = (new FormFactory())->create(ContactType::class);
        $view = $form->createView();

        self::assertTrue(($view->options['csrf_protection'] ?? false) === true);
    }

    public function testBuilderUsesCsrfProtectionByDefault(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $view = $form->createView();

        self::assertTrue(($view->options['csrf_protection'] ?? false) === true);
    }

    public function testFluentFormGeneratorUsesCsrfProtectionByDefault(): void
    {
        $form = (new FormGenerator('contact'))
            ->open()
            ->addText('name')
            ->getForm();

        $view = $form->createView();

        self::assertTrue(($view->options['csrf_protection'] ?? false) === true);
    }
}
