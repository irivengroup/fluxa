<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests\Fixtures\Hook;

use Iriven\PhpFormGenerator\Domain\Contract\FormHookInterface;
use Iriven\PhpFormGenerator\Domain\Form\Form;

final class AfterRenderHook implements FormHookInterface
{
    public static function getName(): string
    {
        return 'after_render';
    }

    public function __invoke(Form $form, array $context = []): void
    {
        $form->appendError('_form', 'After render hook reached.');
    }
}
