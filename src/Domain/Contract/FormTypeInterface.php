<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Contract;

use Iriven\PhpFormGenerator\Domain\Form\FormBuilder;

interface FormTypeInterface
{
    /** @param array<string, mixed> $options */
    public function buildForm(FormBuilder $builder, array $options = []): void;

    public function configureOptions(OptionsResolverInterface $resolver): void;
}
