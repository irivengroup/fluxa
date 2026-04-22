<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Field;

final class CaptchaType extends TextType
{
    public static function htmlType(): string
    {
        return 'captcha';
    }
}
