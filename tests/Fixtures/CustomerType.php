<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests\Fixtures;

use Iriven\Fluxa\Domain\Constraint\Required;
use Iriven\Fluxa\Domain\Contract\FormTypeInterface;
use Iriven\Fluxa\Domain\Contract\OptionsResolverInterface;
use Iriven\Fluxa\Domain\Field\CountryType;
use Iriven\Fluxa\Domain\Field\EmailType;
use Iriven\Fluxa\Domain\Field\TextType;
use Iriven\Fluxa\Domain\Form\FormBuilder;

final class CustomerType implements FormTypeInterface
{
    /** @param array<string, mixed> $options */
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
