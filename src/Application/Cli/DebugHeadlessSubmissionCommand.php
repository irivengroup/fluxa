<?php
declare(strict_types=1);
namespace Iriven\Fluxa\Application\Cli;
use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\Headless\HeadlessFormProcessor;
/** @api */
final class DebugHeadlessSubmissionCommand implements CliCommandInterface
{
    public function name(): string { return 'debug:headless-submission'; }
    /** @param array<int, string> $args */
    public function run(array $args = []): string
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $payload = (new HeadlessFormProcessor())->submit($form, ['email' => 'john@example.com']);
        return json_encode($payload, JSON_PRETTY_PRINT) ?: '{}';
    }
}
