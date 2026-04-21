<?php
declare(strict_types=1);
namespace Iriven\PhpFormGenerator\Application\PublicApi;
use Iriven\PhpFormGenerator\Application\FormRuntimeContext;
use Iriven\PhpFormGenerator\Application\Frontend\FrontendSdk;
use Iriven\PhpFormGenerator\Domain\Form\Form;
/** @api */
final class UnifiedSchemaExporter
{
    public function __construct(
        private readonly FrontendSdk $sdk,
        private readonly PublicApiContract $contract = new PublicApiContract(),
    ) {}
    /** @return array<string, mixed> */
    public function export(Form $form, ?FormRuntimeContext $runtimeContext = null): array
    {
        $sdkSchema = $this->sdk->buildSchema($form, $runtimeContext);
        return [
            'name' => $sdkSchema['form']['name'] ?? $form->getName(),
            'method' => $sdkSchema['form']['method'] ?? 'POST',
            'action' => $sdkSchema['form']['action'] ?? null,
            'fields' => $sdkSchema['fields'] ?? [],
            'ui' => $sdkSchema['ui'] ?? [],
            'runtime' => $sdkSchema['runtime'] ?? [],
            'validation' => $sdkSchema['validation'] ?? [],
            'rendering' => $sdkSchema['runtime']['rendering'] ?? [],
            'schema' => $sdkSchema['schema'] ?? [],
            'sdk' => $sdkSchema['sdk'] ?? [],
        ];
    }
}
