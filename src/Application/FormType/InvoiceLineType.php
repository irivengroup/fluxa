<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Application\FormType;

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
            ->add('quantity', IntegerType::class, ['constraints' => [new Required()]])
            ->add('price', FloatType::class, ['constraints' => [new Required()]]);
    }

    public function configureOptions(OptionsResolverInterface $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
        ]);
    }
}
