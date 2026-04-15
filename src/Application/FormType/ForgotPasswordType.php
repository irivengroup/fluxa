<?php
declare(strict_types=1);
namespace Iriven\PhpFormGenerator\Application\FormType;
use Iriven\PhpFormGenerator\Domain\Constraint\Length;
use Iriven\PhpFormGenerator\Domain\Constraint\Required;
use Iriven\PhpFormGenerator\Domain\Contract\FormTypeInterface;
use Iriven\PhpFormGenerator\Domain\Contract\OptionsResolverInterface;
use Iriven\PhpFormGenerator\Domain\Field\EmailType;
use Iriven\PhpFormGenerator\Domain\Field\SubmitType;
use Iriven\PhpFormGenerator\Domain\Form\FormBuilder;
final class ForgotPasswordType implements FormTypeInterface {
    public function buildForm(FormBuilder $builder, array $options = []): void {
        $builder
            ->add('email', EmailType::class, ['label' => 'Email', 'constraints' => [new Required(), new Length(min: 5, max: 180)], 'autocomplete' => 'username'])
            ->add('submit', SubmitType::class, ['label' => 'Send reset link']);
    }
    public function configureOptions(OptionsResolverInterface $resolver): void {
        $resolver->setDefaults(['method' => 'POST', 'csrf_protection' => true]);
    }
}
