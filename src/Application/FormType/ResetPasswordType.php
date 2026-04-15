<?php
declare(strict_types=1);
namespace Iriven\PhpFormGenerator\Application\FormType;
use Iriven\PhpFormGenerator\Domain\Constraint\Length;
use Iriven\PhpFormGenerator\Domain\Constraint\Required;
use Iriven\PhpFormGenerator\Domain\Contract\FormTypeInterface;
use Iriven\PhpFormGenerator\Domain\Contract\OptionsResolverInterface;
use Iriven\PhpFormGenerator\Domain\Field\HiddenType;
use Iriven\PhpFormGenerator\Domain\Field\PasswordType;
use Iriven\PhpFormGenerator\Domain\Field\SubmitType;
use Iriven\PhpFormGenerator\Domain\Form\FormBuilder;
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
