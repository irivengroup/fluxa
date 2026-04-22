<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests\Fixtures;

use Iriven\Fluxa\Domain\Constraint\Required;
use Iriven\Fluxa\Domain\Contract\FormTypeInterface;
use Iriven\Fluxa\Domain\Contract\OptionsResolverInterface;
use Iriven\Fluxa\Domain\Field\FloatType;
use Iriven\Fluxa\Domain\Field\IntegerType;
use Iriven\Fluxa\Domain\Field\TextType;
use Iriven\Fluxa\Domain\Form\FormBuilder;

final class InvoiceLineType implements FormTypeInterface
{
    /** @param array<string, mixed> $options */
    public function buildForm(FormBuilder $builder, array $options = []): void
    {
        $builder
            ->add('label', TextType::class, ['constraints' => [new Required()]])
            ->add('quantity', IntegerType::class)
            ->add('price', FloatType::class);
    }

    public function configureOptions(OptionsResolverInterface $resolver): void
    {
    }
}
