<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Infrastructure\Security\NullCsrfManager;
use PHPUnit\Framework\TestCase;

final class LoginTypeTest extends TestCase
{
    public function testBuiltinLoginTypeCanBeCreatedByShortName(): void
    {
        $form = (new FormFactory(new NullCsrfManager()))->create('LoginType');

        $view = $form->createView();
        $names = array_map(static fn ($child) => $child->name, $view->children);

        self::assertContains('email', $names);
        self::assertContains('password', $names);
        self::assertContains('remember_me', $names);
        self::assertContains('submit', $names);
    }
}
