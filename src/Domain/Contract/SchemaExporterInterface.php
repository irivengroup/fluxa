<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Contract;

use Iriven\Fluxa\Domain\Form\Form;

interface SchemaExporterInterface
{
    /**
     * @return array<string, mixed>
     */
    public function export(Form $form): array;
}
