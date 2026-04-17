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
    public function export(Form $form, ?FormRuntimeContext $runtimeContext = null): array
    {
        $this->hookKernel?->dispatch('before_export', $form, ['runtime' => $runtimeContext]);
        $this->hookKernel?->dispatch('before_schema_export', $form, ['runtime' => $runtimeContext]);

        $schema = $this->exporter->export($form);

        if ($runtimeContext instanceof FormRuntimeContext) {
            $schema['runtime'] = [
                'theme' => $runtimeContext->theme(),
                'renderer' => $runtimeContext->renderer(),
                'metadata' => $runtimeContext->metadata(),
            ];
        }

        $this->hookKernel?->dispatch('after_schema_export', $form, ['schema' => $schema, 'runtime' => $runtimeContext]);
        $this->hookKernel?->dispatch('after_export', $form, ['schema' => $schema, 'runtime' => $runtimeContext]);

        return $schema;
    }
}
