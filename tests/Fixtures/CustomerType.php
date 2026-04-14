<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests\Fixtures;

use Iriven\PhpFormGenerator\Domain\Constraint\Required;
use Iriven\PhpFormGenerator\Domain\Contract\FormTypeInterface;
use Iriven\PhpFormGenerator\Domain\Contract\OptionsResolverInterface;
use Iriven\PhpFormGenerator\Domain\Field\CountryType;
use Iriven\PhpFormGenerator\Domain\Field\EmailType;
use Iriven\PhpFormGenerator\Domain\Field\TextType;
use Iriven\PhpFormGenerator\Domain\Form\FormBuilder;

final class CustomerType implements FormTypeInterface
{
    public function buildForm(FormBuilder $builder, array $options = []): void
    {
        $builder
            ->add('name', TextType::class, ['constraints' => [new Required()]])
            ->add('email', EmailType::class)
            ->add('country', CountryType::class, ['label' => 'Country']);
    }

    public function configureOptions(OptionsResolverInterface $resolver): void
    {
    }
}
