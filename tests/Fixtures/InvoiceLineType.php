<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests\Fixtures;

use Iriven\PhpFormGenerator\Domain\Constraint\Required;
use Iriven\PhpFormGenerator\Domain\Contract\FormTypeInterface;
use Iriven\PhpFormGenerator\Domain\Field\FloatType;
use Iriven\PhpFormGenerator\Domain\Field\IntegerType;
use Iriven\PhpFormGenerator\Domain\Field\TextType;
use Iriven\PhpFormGenerator\Domain\Form\FormBuilder;

final class InvoiceLineType implements FormTypeInterface
{
    public function buildForm(FormBuilder $builder, array $options = []): void
    {
        $builder
            ->add('label', TextType::class, ['constraints' => [new Required()]])
            ->add('quantity', IntegerType::class)
            ->add('price', FloatType::class);
    }

    public function configureOptions(array $options = []): array
    {
        return [];
    }
}
