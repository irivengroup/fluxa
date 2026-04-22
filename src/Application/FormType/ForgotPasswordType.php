<?php
declare(strict_types=1);
namespace Iriven\Fluxa\Application\FormType;
use Iriven\Fluxa\Domain\Constraint\Length;
use Iriven\Fluxa\Domain\Constraint\Required;
use Iriven\Fluxa\Domain\Contract\FormTypeInterface;
use Iriven\Fluxa\Domain\Contract\OptionsResolverInterface;
use Iriven\Fluxa\Domain\Field\EmailType;
use Iriven\Fluxa\Domain\Field\SubmitType;
use Iriven\Fluxa\Domain\Form\FormBuilder;
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
