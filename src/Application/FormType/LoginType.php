<?php
declare(strict_types=1);
namespace Iriven\Fluxa\Application\FormType;
use Iriven\Fluxa\Domain\Constraint\Length;
use Iriven\Fluxa\Domain\Constraint\Required;
use Iriven\Fluxa\Domain\Contract\FormTypeInterface;
use Iriven\Fluxa\Domain\Contract\OptionsResolverInterface;
use Iriven\Fluxa\Domain\Field\CheckboxType;
use Iriven\Fluxa\Domain\Field\EmailType;
use Iriven\Fluxa\Domain\Field\PasswordType;
use Iriven\Fluxa\Domain\Field\SubmitType;
use Iriven\Fluxa\Domain\Form\FormBuilder;
final class LoginType implements FormTypeInterface {
    public function buildForm(FormBuilder $builder, array $options = []): void {
        $builder
            ->add('email', EmailType::class, ['label' => 'Email', 'constraints' => [new Required(), new Length(min: 5, max: 180)], 'autocomplete' => 'username'])
            ->add('password', PasswordType::class, ['label' => 'Password', 'constraints' => [new Required(), new Length(min: 6, max: 255)], 'autocomplete' => 'current-password'])
            ->add('remember_me', CheckboxType::class, ['label' => 'Remember me', 'required' => false])
            ->add('submit', SubmitType::class, ['label' => 'Sign in']);
    }
    public function configureOptions(OptionsResolverInterface $resolver): void {
        $resolver->setDefaults(['method' => 'POST', 'csrf_protection' => true]);
    }
}
