<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Infrastructure\Security;

use Iriven\PhpFormGenerator\Domain\Contract\CaptchaManagerInterface;
use RuntimeException;

final class SessionCaptchaManager implements CaptchaManagerInterface
{
    public function __construct(
        private readonly int $ttlSeconds = 300,
        private readonly int $maxAttempts = 5,
    ) {
        $this->ensureSessionStarted();
        $_SESSION['_pfg_captcha'] ??= [];
    }

    public function generateCode(string $key, int $minLength = 5, int $maxLength = 8): string
    {
        $minLength = max(5, $minLength);
        $maxLength = max($minLength, min(8, $maxLength));

        $length = random_int($minLength, $maxLength);
        $code = $this->generateCaseSensitiveCode($length);

        $_SESSION['_pfg_captcha'][$key] = [
            'code' => $code,
            'expires_at' => time() + max(30, $this->ttlSeconds),
            'attempts_left' => max(1, $this->maxAttempts),
        ];

        return $code;
    }

    public function isCodeValid(string $key, ?string $input): bool
    {
        if ($input === null || $input === '') {
            return false;
        }

        $challenge = $_SESSION['_pfg_captcha'][$key] ?? null;
        if (!is_array($challenge)) {
            return false;
        }

        $expected = $challenge['code'] ?? null;
        $expiresAt = $challenge['expires_at'] ?? null;
        $attemptsLeft = $challenge['attempts_left'] ?? null;

        if (!is_string($expected) || !is_int($expiresAt) || !is_int($attemptsLeft)) {
            unset($_SESSION['_pfg_captcha'][$key]);
            return false;
        }

        if ($expiresAt < time()) {
            unset($_SESSION['_pfg_captcha'][$key]);
            return false;
        }

        if ($attemptsLeft <= 0) {
            unset($_SESSION['_pfg_captcha'][$key]);
            return false;
        }

        $isValid = hash_equals($expected, $input);

        if ($isValid) {
            unset($_SESSION['_pfg_captcha'][$key]);
            return true;
        }

        $challenge['attempts_left'] = $attemptsLeft - 1;
        if ($challenge['attempts_left'] <= 0) {
            unset($_SESSION['_pfg_captcha'][$key]);
        } else {
            $_SESSION['_pfg_captcha'][$key] = $challenge;
        }

        return false;
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
