<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Application\Cli;

use Iriven\Fluxa\Application\Debug\RuntimeInspector;
use Iriven\Fluxa\Application\FormFactory;

/** @api */
final class DebugFormCommand implements CliCommandInterface
{
    public function name(): string
    {
        return 'debug:form';
    }

    /**
     * @param array<int, string> $args
     */
    public function run(array $args = []): string
    {
        $name = $args[0] ?? 'contact';
        $form = (new FormFactory())->createBuilder($name)->getForm();
        $data = (new RuntimeInspector())->inspect($form);

        return json_encode($data, JSON_PRETTY_PRINT) ?: '{}';
    }
}
