<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Application\Events;

use Iriven\Fluxa\Domain\Form\Form;

/** @api */
final class FormSubmitEvent
{
    /**
     * @param array<string, mixed> $context
     */
    public function __construct(
        public Form $form,
        public array $context = [],
    ) {
    }
}
