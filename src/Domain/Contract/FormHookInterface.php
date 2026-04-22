<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Contract;

use Iriven\Fluxa\Domain\Form\Form;

interface FormHookInterface extends HookInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function __invoke(Form $form, array $context = []): void;
}
