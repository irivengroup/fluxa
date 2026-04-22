<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests\Fixtures\Hook;

use Iriven\Fluxa\Domain\Contract\FormHookInterface;
use Iriven\Fluxa\Domain\Form\Form;

final class AfterSchemaExportHook implements FormHookInterface
{
    public static function getName(): string
    {
        return 'after_schema_export';
    }

    public function __invoke(Form $form, array $context = []): void
    {
        $form->appendError('_form', 'After schema export hook reached.');
    }
}
