<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Contract;

use Iriven\Fluxa\Domain\Form\FormBuilder;

interface FormTypeInterface
{
    /** @param array<string, mixed> $options */
    public function buildForm(FormBuilder $builder, array $options = []): void;

    public function configureOptions(OptionsResolverInterface $resolver): void;
}
