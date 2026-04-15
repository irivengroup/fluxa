<?php
declare(strict_types=1);
namespace Iriven\PhpFormGenerator\Tests;
use Iriven\PhpFormGenerator\Application\FormFactory;
use Iriven\PhpFormGenerator\Infrastructure\Security\NullCsrfManager;
use PHPUnit\Framework\TestCase;
final class ForgotAndResetPasswordTypeTest extends TestCase
{
    public function testBuiltinForgotPasswordTypeCanBeCreatedByShortName(): void
    {
        $form = (new FormFactory(new NullCsrfManager()))->create('ForgotPasswordType');
        $names = array_map(static fn ($child) => $child->name, $form->createView()->children);
        self::assertContains('email', $names);
        self::assertContains('submit', $names);
    }

    public function testBuiltinResetPasswordTypeCanBeCreatedByShortName(): void
    {
        $form = (new FormFactory(new NullCsrfManager()))->create('ResetPasswordType');
        $names = array_map(static fn ($child) => $child->name, $form->createView()->children);
        self::assertContains('token', $names);
        self::assertContains('password', $names);
        self::assertContains('password_confirmation', $names);
        self::assertContains('submit', $names);
    }
}
