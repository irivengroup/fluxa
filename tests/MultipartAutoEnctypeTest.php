<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests;

use Iriven\PhpFormGenerator\Application\FormGenerator;
use Iriven\PhpFormGenerator\Presentation\Html\HtmlRenderer;
use PHPUnit\Framework\TestCase;

final class MultipartAutoEnctypeTest extends TestCase
{
    public function testFileFieldAutomaticallyEnablesMultipartEnctype(): void
    {
        $form = (new FormGenerator('upload'))
            ->open(['method' => 'POST'])
            ->addFile('attachment')
            ->getForm();

        $html = (new HtmlRenderer())->renderForm($form->createView());

        self::assertStringContainsString('enctype="multipart/form-data"', $html);
    }
}
