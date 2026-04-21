<?php
declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Integration\Laravel;

use Iriven\PhpFormGenerator\Application\FormFactory;
use Iriven\PhpFormGenerator\Domain\Form\Form;

/** @api */
final class LaravelFormBridge
{
    public function __construct(
        private readonly ?FormFactory $factory = null,
    ) {}

    public function make(string $name): Form
    {
        return ($this->factory ?? new FormFactory())->createBuilder($name)->getForm();
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function validate(Form $form, array $payload): array
    {
        return ['form' => $form->getName(), 'payload' => $payload, 'integration' => 'laravel'];
    }
}
