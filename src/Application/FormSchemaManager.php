<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Application;

use Iriven\PhpFormGenerator\Domain\Contract\SchemaExporterInterface;
use Iriven\PhpFormGenerator\Domain\Form\Form;

final class FormSchemaManager
{
    public function __construct(
        private readonly SchemaExporterInterface $exporter,
        private readonly ?FormHookKernel $hookKernel = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function export(Form $form): array
    {
        $this->hookKernel?->dispatch('before_schema_export', $form);

        $schema = $this->exporter->export($form);

        $this->hookKernel?->dispatch('after_schema_export', $form, ['schema' => $schema]);

        return $schema;
    }
}
