<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests\Fixtures;

use Iriven\Fluxa\Domain\Constraint\Required;
use Iriven\Fluxa\Domain\Contract\FormTypeInterface;
use Iriven\Fluxa\Domain\Contract\OptionsResolverInterface;
use Iriven\Fluxa\Domain\Field\CollectionType;
use Iriven\Fluxa\Domain\Field\DatetimeType;
use Iriven\Fluxa\Domain\Field\SubmitType;
use Iriven\Fluxa\Domain\Form\FormBuilder;

final class InvoiceType implements FormTypeInterface
{
    /** @param array<string, mixed> $options */
    public function buildForm(FormBuilder $builder, array $options = []): void
    {
        $builder
            ->addFieldset(['legend' => 'Invoice'])
            ->add('customer', CustomerType::class, ['label' => 'Customer'])
            ->add('issuedAt', DatetimeType::class, ['constraints' => [new Required()]])
            ->add('items', CollectionType::class, [
                'entry_type' => InvoiceLineType::class,
                'entry_options' => [],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
            ])
            ->endFieldset()
            ->add('submit', SubmitType::class, ['label' => 'Save']);
    }

    public function configureOptions(OptionsResolverInterface $resolver): void
    {
        $resolver->setDefaults(['method' => 'POST']);
    }
}
