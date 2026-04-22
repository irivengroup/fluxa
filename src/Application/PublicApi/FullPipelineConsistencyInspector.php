<?php
declare(strict_types=1);
namespace Iriven\Fluxa\Application\PublicApi;
use Iriven\Fluxa\Application\FormRuntimeContext;
use Iriven\Fluxa\Application\Headless\HeadlessFormProcessor;
use Iriven\Fluxa\Domain\Form\Form;
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
