<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormHookKernel;
use Iriven\Fluxa\Infrastructure\Http\ArrayRequest;
use Iriven\Fluxa\Tests\Fixtures\Hook\InvalidateOnPostSubmitHook;
use Iriven\Fluxa\Tests\Fixtures\Hook\InvalidateOnPreSubmitHook;
use PHPUnit\Framework\TestCase;

final class HookLifecycleRuntimeTest extends TestCase
{
    public function testPreSubmitHookIsDispatchedDuringHandleRequest(): void
    {
        $hooks = (new FormHookKernel())->register(new InvalidateOnPreSubmitHook());
        $factory = new FormFactory(hookKernel: $hooks);
        $builder = $factory->createBuilder('demo');
        $builder->add('name', 'TextType');
        $form = $builder->getForm();

        $form->handleRequest(new ArrayRequest('POST', [
            'demo' => ['name' => 'Alice'],
        ]));

        self::assertTrue($form->isSubmitted());
        self::assertArrayHasKey('_form', $form->getErrors());
        self::assertContains('Pre-submit hook reached.', $form->getErrors()['_form']);
    }

    public function testPostSubmitHookIsDispatchedDuringHandleRequest(): void
    {
        $hooks = (new FormHookKernel())->register(new InvalidateOnPostSubmitHook());
        $factory = new FormFactory(hookKernel: $hooks);
        $builder = $factory->createBuilder('demo');
        $builder->add('name', 'TextType');
        $form = $builder->getForm();

        $form->handleRequest(new ArrayRequest('POST', [
            'demo' => ['name' => 'Alice'],
        ]));

        self::assertTrue($form->isSubmitted());
        self::assertArrayHasKey('_form', $form->getErrors());
        self::assertContains('Post-submit hook reached.', $form->getErrors()['_form']);
    }
}
