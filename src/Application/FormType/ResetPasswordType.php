<?php
declare(strict_types=1);
namespace Iriven\Fluxa\Application\FormType;
use Iriven\Fluxa\Domain\Constraint\Length;
use Iriven\Fluxa\Domain\Constraint\Required;
use Iriven\Fluxa\Domain\Contract\FormTypeInterface;
use Iriven\Fluxa\Domain\Contract\OptionsResolverInterface;
use Iriven\Fluxa\Domain\Field\HiddenType;
use Iriven\Fluxa\Domain\Field\PasswordType;
use Iriven\Fluxa\Domain\Field\SubmitType;
use Iriven\Fluxa\Domain\Form\FormBuilder;
final class ResetPasswordType implements FormTypeInterface {
    public function buildForm(FormBuilder $builder, array $options = []): void {
        $builder
            ->add('token', HiddenType::class)
            ->add('password', PasswordType::class, ['label' => 'New password', 'constraints' => [new Required(), new Length(min: 6, max: 255)], 'autocomplete' => 'new-password'])
            ->add('password_confirmation', PasswordType::class, ['label' => 'Confirm password', 'constraints' => [new Required(), new Length(min: 6, max: 255)], 'autocomplete' => 'new-password'])
            ->add('submit', SubmitType::class, ['label' => 'Reset password']);
    }
    public function configureOptions(OptionsResolverInterface $resolver): void {
        $resolver->setDefaults(['method' => 'POST', 'csrf_protection' => true]);
    }
}
