<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Application;

use Iriven\PhpFormGenerator\Domain\Form\Form;
use Iriven\PhpFormGenerator\Presentation\Html\HtmlRenderer;
use Iriven\PhpFormGenerator\Presentation\Html\HtmlRendererFactory;

final class FormRenderManager
{
    public function __construct(
        private readonly HtmlRendererFactory $rendererFactory,
        private readonly ?FormHookKernel $hookKernel = null,
    ) {
    }

    public function render(Form $form, ?string $themeAlias = null): string
    {
        $renderer = $this->rendererFactory->create($themeAlias);
        $view = $form->createView();

        $this->hookKernel?->dispatch('before_render', $form, [
            'theme' => $themeAlias,
            'renderer' => $renderer::class,
            'view' => $view,
        ]);

        $html = $renderer->renderForm($view);

        $this->hookKernel?->dispatch('after_render', $form, [
            'theme' => $themeAlias,
            'renderer' => $renderer::class,
            'view' => $view,
            'html' => $html,
        ]);

        return $html;
    }
}
