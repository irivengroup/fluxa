<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Presentation\Html\Theme;

interface ThemeInterface
{
    public function formClass(): string;
    public function rowClass(): string;
    public function labelClass(): string;
    public function inputClass(): string;
    public function errorClass(): string;
    public function fieldsetClass(): string;
}
