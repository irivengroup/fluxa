<?php
declare(strict_types=1);
namespace Iriven\PhpFormGenerator\Application\PublicApi;
use Iriven\PhpFormGenerator\Application\FormRuntimeContext;
use Iriven\PhpFormGenerator\Application\Headless\HeadlessFormProcessor;
use Iriven\PhpFormGenerator\Domain\Form\Form;
/** @api */
final class FullPipelineConsistencyInspector
{
    public function __construct(
        private readonly UnifiedSchemaExporter $exporter,
        private readonly HeadlessFormProcessor $headless,
        private readonly PublicApiStabilityChecker $checker = new PublicApiStabilityChecker(),
    ) {}
    public function isConsistent(Form $form, ?FormRuntimeContext $runtimeContext = null): bool
    {
        $unified = $this->exporter->export($form, $runtimeContext);
        $headless = $this->headless->schema($form);
        if (!$this->checker->isStable($unified)) {
            return false;
        }
        return isset($headless['schema']['version']) && isset($unified['schema']['version']);
    }
}
