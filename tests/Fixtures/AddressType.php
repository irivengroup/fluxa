<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests\Fixtures;

use Iriven\Fluxa\Domain\Contract\FormTypeInterface;
use Iriven\Fluxa\Domain\Contract\OptionsResolverInterface;
use Iriven\Fluxa\Domain\Field\TextType;
use Iriven\Fluxa\Domain\Form\FormBuilder;

final class AddressType implements FormTypeInterface
{
    /** @param array<string, mixed> $options */
    public function buildForm(FormBuilder $builder, array $options = []): void
    {
        $builder
            ->add('street', TextType::class, ['label' => 'Street'])
            ->add('city', TextType::class, ['label' => 'City']);
    }

    public function configureOptions(OptionsResolverInterface $resolver): void
    {
    }
}
