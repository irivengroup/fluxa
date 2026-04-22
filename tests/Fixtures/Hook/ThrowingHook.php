<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests\Fixtures\Hook;

use Iriven\Fluxa\Domain\Contract\FormHookInterface;
use Iriven\Fluxa\Domain\Form\Form;
use RuntimeException;

final class ThrowingHook implements FormHookInterface
{
    public static function getName(): string
    {
        return 'post_submit';
    }

    public function __invoke(Form $form, array $context = []): void
    {
        throw new RuntimeException('Boom');
    }
}
