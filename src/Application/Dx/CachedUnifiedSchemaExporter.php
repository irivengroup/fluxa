<?php
declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Application\Dx;

use Iriven\PhpFormGenerator\Application\FormRuntimeContext;
use Iriven\PhpFormGenerator\Application\PublicApi\UnifiedSchemaExporter;
use Iriven\PhpFormGenerator\Domain\Form\Form;

/** @api */
final class CachedUnifiedSchemaExporter
{
    public function __construct(
        private readonly UnifiedSchemaExporter $exporter,
        private readonly InMemorySchemaCache $cache = new InMemorySchemaCache(),
        private readonly SchemaCacheKeyGenerator $keys = new SchemaCacheKeyGenerator(),
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function export(Form $form, ?FormRuntimeContext $runtimeContext = null): array
    {
        $context = [
            'theme' => $runtimeContext?->theme() ?? 'default',
            'renderer' => $runtimeContext?->renderer(),
        ];
        $key = $this->keys->generate($form->getName(), $context);

        if ($this->cache->has($key)) {
            $cached = $this->cache->get($key);
            return $cached ?? [];
        }

        $schema = $this->exporter->export($form, $runtimeContext);
        $this->cache->set($key, $schema);
        return $schema;
    }
}
