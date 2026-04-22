<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Infrastructure\Security\SessionCaptchaManager;
use Iriven\Fluxa\Infrastructure\Security\SessionCsrfManager;
use PHPUnit\Framework\TestCase;

final class SessionSecurityManagersTest extends TestCase
{
    public function testSessionManagersCanBeConstructedWhenSessionIsAvailable(): void
    {
        $csrf = new SessionCsrfManager();
        $captcha = new SessionCaptchaManager();

        self::assertNotSame('', $csrf->generateToken('test'));
        self::assertNotSame('', $captcha->generateCode('captcha', 5, 5));
    }
}
