<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormGenerator;
use Iriven\Fluxa\Infrastructure\Security\NullCsrfManager;
use Iriven\Fluxa\Presentation\Html\HtmlRenderer;
use PHPUnit\Framework\TestCase;

final class HiddenFieldRenderingTest extends TestCase
{
    public function testHiddenFieldLabelIsNeverRendered(): void
    {
        $form = (new FormGenerator('hidden'))
            ->open(['method' => 'POST'], ['csrf_protection' => false, 'csrf_manager' => new NullCsrfManager()])
            ->addHidden('token', ['label' => 'Secret token'])
            ->getForm();

        $html = (new HtmlRenderer())->renderForm($form->createView());

        self::assertStringContainsString('name="hidden[token]"', $html);
        self::assertStringNotContainsString('Secret token', $html);
        self::assertStringNotContainsString('<label', $html);
    }
}
