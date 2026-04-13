<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Presentation\Html;

use Iriven\PhpFormGenerator\Domain\Field\AbstractFieldType;
use Iriven\PhpFormGenerator\Domain\Field\CountryType;
use Iriven\PhpFormGenerator\Domain\Form\Fieldset;
use Iriven\PhpFormGenerator\Domain\Form\FormView;
use Iriven\PhpFormGenerator\Presentation\Html\Theme\DefaultTheme;
use Iriven\PhpFormGenerator\Presentation\Html\Theme\ThemeInterface;

final class HtmlRenderer
{
    public function __construct(private readonly ThemeInterface $theme = new DefaultTheme())
    {
    }

    public function renderForm(FormView $view): string
    {
        $html = sprintf('<form method="%s" action="%s" class="%s">', $this->e($view->vars['method'] ?? 'POST'), $this->e($view->vars['action'] ?? ''), $this->e($this->theme->formClass()));
        $grouped = [];
        foreach ($view->children as $child) {
            $grouped[$child->name] = $child;
        }

        $used = [];
        foreach ($view->fieldsets as $fieldset) {
            $html .= $this->renderFieldset($fieldset, $grouped, $used);
        }
        foreach ($view->children as $child) {
            if (!isset($used[$child->name])) {
                $html .= $this->renderRow($child);
            }
        }
        return $html . '</form>';
    }

    private function renderFieldset(Fieldset $fieldset, array $grouped, array &$used): string
    {
        $html = '<fieldset class="' . $this->e($this->theme->fieldsetClass()) . '">';
        if (($fieldset->options['legend'] ?? null) !== null) {
            $html .= '<legend>' . $this->e((string) $fieldset->options['legend']) . '</legend>';
        }
        if (($fieldset->options['description'] ?? null) !== null) {
            $html .= '<p>' . $this->e((string) $fieldset->options['description']) . '</p>';
        }
        foreach ($fieldset->fields as $name) {
            if (isset($grouped[$name])) {
                $used[$name] = true;
                $html .= $this->renderRow($grouped[$name]);
            }
        }
        return $html . '</fieldset>';
    }

    public function renderRow(FormView $view): string
    {
        if ($view->type === 'compound') {
            $html = '<div class="' . $this->e($this->theme->rowClass()) . '"><fieldset><legend>' . $this->e((string) ($view->vars['label'] ?? $view->name)) . '</legend>';
            foreach ($view->children as $child) {
                $html .= $this->renderRow($child);
            }
            return $html . '</fieldset></div>';
        }

        if ($view->type === 'collection') {
            $html = '<div class="' . $this->e($this->theme->rowClass()) . '"><label class="' . $this->e($this->theme->labelClass()) . '">' . $this->e((string) ($view->vars['label'] ?? $view->name)) . '</label>';
            foreach ($view->children as $child) {
                $html .= '<div data-collection-entry="1">';
                foreach ($child->children as $grandChild) {
                    $html .= $this->renderRow($grandChild);
                }
                $html .= '</div>';
            }
            return $html . '</div>';
        }

        $html = '<div class="' . $this->e($this->theme->rowClass()) . '">';
        if (!in_array($view->type, ['Iriven\\PhpFormGenerator\\Domain\\Field\\HiddenType', 'Iriven\\PhpFormGenerator\\Domain\\Field\\SubmitType'], true)) {
            $html .= '<label for="' . $this->e($view->id) . '" class="' . $this->e($this->theme->labelClass()) . '">' . $this->e((string) ($view->vars['label'] ?? $view->name)) . '</label>';
        }
        $html .= $this->renderWidget($view);
        foreach ($view->errors as $error) {
            $html .= '<div class="' . $this->e($this->theme->errorClass()) . '">' . $this->e($error) . '</div>';
        }
        return $html . '</div>';
    }

    public function renderWidget(FormView $view): string
    {
        $typeClass = $view->vars['type_class'] ?? $view->type;
        $attrs = ' id="' . $this->e($view->id) . '" name="' . $this->e($view->fullName) . '" class="' . $this->e($this->theme->inputClass()) . '"';
        foreach (($view->vars['attr'] ?? []) as $name => $value) {
            $attrs .= ' ' . $this->e((string) $name) . '="' . $this->e((string) $value) . '"';
        }

        if (is_string($typeClass) && is_subclass_of($typeClass, AbstractFieldType::class)) {
            $htmlType = $typeClass::htmlType();
            if ($htmlType === 'textarea') {
                return '<textarea' . $attrs . '>' . $this->e((string) $view->value) . '</textarea>';
            }
            if ($htmlType === 'select' && is_a($typeClass, CountryType::class, true)) {
                $html = '<select' . $attrs . '>';
                foreach ($typeClass::choices() as $label => $value) {
                    $selected = ((string) $view->value === (string) $value) ? ' selected' : '';
                    $html .= '<option value="' . $this->e((string) $value) . '"' . $selected . '>' . $this->e((string) $label) . '</option>';
                }
                return $html . '</select>';
            }
            if ($htmlType === 'checkbox') {
                $checked = $view->value ? ' checked' : '';
                return '<input type="checkbox" value="1"' . $attrs . $checked . ' />';
            }
            if ($htmlType === 'submit') {
                return '<button type="submit"' . $attrs . '>' . $this->e((string) ($view->vars['label'] ?? 'Submit')) . '</button>';
            }
            return '<input type="' . $this->e($htmlType) . '" value="' . $this->e((string) $view->value) . '"' . $attrs . ' />';
        }

        return '<input type="text" value="' . $this->e((string) $view->value) . '"' . $attrs . ' />';
    }

    private function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
