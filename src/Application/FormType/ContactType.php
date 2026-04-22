<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Application\FormType;

use Iriven\Fluxa\Domain\Constraint\Email;
use Iriven\Fluxa\Domain\Constraint\Length;
use Iriven\Fluxa\Domain\Constraint\Required;
use Iriven\Fluxa\Domain\Contract\FormTypeInterface;
use Iriven\Fluxa\Domain\Contract\OptionsResolverInterface;
use Iriven\Fluxa\Domain\Field\CaptchaType;
use Iriven\Fluxa\Domain\Field\CountryType;
use Iriven\Fluxa\Domain\Field\EmailType;
use Iriven\Fluxa\Domain\Field\PhoneType;
use Iriven\Fluxa\Domain\Field\SubmitType;
use Iriven\Fluxa\Domain\Field\TextareaType;
use Iriven\Fluxa\Domain\Field\TextType;
use Iriven\Fluxa\Domain\Form\FormBuilder;

final class ContactType implements FormTypeInterface
{
    /** @param array<string, mixed> $options */
    public function buildForm(FormBuilder $builder, array $options = []): void
    {
        $builder
            ->addFieldset([
                'legend' => 'Contact information',
                'description' => 'Basic information required to identify the sender.',
            ])
            ->add('name', TextType::class, [
                'label' => 'Name',
                'constraints' => [new Required(), new Length(min: 2, max: 120)],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [new Required(), new Email()],
            ])
            ->add('phone', PhoneType::class, [
                'label' => 'Phone',
                'required' => false,
            ])
            ->add('country', CountryType::class, [
                'label' => 'Country',
                'required' => false,
            ])
            ->endFieldset()
            ->addFieldset([
                'legend' => 'Message',
                'description' => 'Describe your request.',
            ])
            ->add('subject', TextType::class, [
                'label' => 'Subject',
                'constraints' => [new Required(), new Length(min: 3, max: 180)],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'constraints' => [new Required(), new Length(min: 10, max: 5000)],
                'attr' => ['rows' => 6],
            ])
            ->endFieldset()
            ->add('captcha', CaptchaType::class, [
                'label' => 'Security code',
                'min_length' => 5,
                'max_length' => 8,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Send message']);
    }

    public function configureOptions(OptionsResolverInterface $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'POST',
            'csrf_protection' => true,
        ]);
    }
}
