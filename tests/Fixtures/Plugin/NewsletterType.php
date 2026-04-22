<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests\Fixtures\Plugin;

use Iriven\Fluxa\Domain\Contract\FormTypeInterface;
use Iriven\Fluxa\Domain\Contract\OptionsResolverInterface;
use Iriven\Fluxa\Domain\Field\EmailType;
use Iriven\Fluxa\Domain\Field\SubmitType;
use Iriven\Fluxa\Domain\Form\FormBuilder;

final class NewsletterType implements FormTypeInterface
{
    /** @param array<string, mixed> $options */
    public function buildForm(FormBuilder $builder, array $options = []): void
    {
        $builder
            ->add('email', EmailType::class, ['required' => true])
            ->add('submit', SubmitType::class, ['label' => 'Subscribe']);
    }

    public function configureOptions(OptionsResolverInterface $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'POST',
            'csrf_protection' => false,
        ]);
    }
}
