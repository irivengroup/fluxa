<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Infrastructure\Security;

use Iriven\PhpFormGenerator\Domain\Contract\CaptchaManagerInterface;
use RuntimeException;

final class SessionCaptchaManager implements CaptchaManagerInterface
{
    public function __construct()
    {
        $this->ensureSessionStarted();
        $_SESSION['_pfg_captcha'] ??= [];
    }

    public function generateCode(string $key, int $minLength = 5, int $maxLength = 8): string
    {
        $minLength = max(5, $minLength);
        $maxLength = max($minLength, min(8, $maxLength));

        $length = random_int($minLength, $maxLength);
        $code = $this->generateCaseSensitiveCode($length);

        $_SESSION['_pfg_captcha'][$key] = $code;

        return $code;
    }

    public function isCodeValid(string $key, ?string $input): bool
    {
        if ($input === null || $input === '') {
            return false;
        }

        $expected = $_SESSION['_pfg_captcha'][$key] ?? null;
        unset($_SESSION['_pfg_captcha'][$key]);

        return is_string($expected) && hash_equals($expected, $input);
    }

    private function ensureSessionStarted(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        if (headers_sent($file, $line)) {
            throw new RuntimeException(sprintf(
                'Unable to start session for captcha storage because headers were already sent in %s on line %d.',
                $file,
                $line
            ));
        }

        session_start();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            throw new RuntimeException('Unable to start session for captcha storage.');
        }
    }

    private function generateCaseSensitiveCode(int $length): string
    {
        $uppercase = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $lowercase = 'abcdefghijkmnopqrstuvwxyz';
        $digits = '23456789';
        $all = $uppercase . $lowercase . $digits;

        $chars = [
            $uppercase[random_int(0, strlen($uppercase) - 1)],
            $lowercase[random_int(0, strlen($lowercase) - 1)],
        ];

        while (count($chars) < $length) {
            $chars[] = $all[random_int(0, strlen($all) - 1)];
        }

        shuffle($chars);

        return implode('', $chars);
    }
}
