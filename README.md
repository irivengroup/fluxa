# PhpFormGenerator V3.1 Enterprise Starter

Framework de formulaires PHP orienté cycle de vie :

- `FormFactory`
- `FormBuilder`
- `FormTypeInterface`
- validation
- CSRF
- mapping array / objet
- nested forms
- collection support
- events
- renderer HTML
- types historiques réintroduits via classes dédiées

## Exemple rapide

```php
use Iriven\PhpFormGenerator\Application\FormFactory;
use Iriven\PhpFormGenerator\Domain\Field\TextType;
use Iriven\PhpFormGenerator\Domain\Field\EmailType;
use Iriven\PhpFormGenerator\Domain\Field\SubmitType;
use Iriven\PhpFormGenerator\Infrastructure\Http\ArrayRequest;
use Iriven\PhpFormGenerator\Infrastructure\Mapping\ArrayDataMapper;
use Iriven\PhpFormGenerator\Infrastructure\Security\SessionCsrfManager;
use Iriven\PhpFormGenerator\Presentation\Html\HtmlRenderer;

$factory = new FormFactory(
    dataMapper: new ArrayDataMapper(),
    csrfManager: new SessionCsrfManager(),
);

$form = $factory->createBuilder('contact')
    ->add('name', TextType::class, [
        'label' => 'Nom',
        'constraints' => [],
    ])
    ->add('email', EmailType::class, [
        'label' => 'Email',
    ])
    ->add('submit', SubmitType::class, ['label' => 'Envoyer'])
    ->getForm();

$form->handleRequest(new ArrayRequest([
    'contact' => [
        'name' => 'Alice',
        'email' => 'alice@example.com',
        '_token' => $form->getCsrfToken(),
    ],
]));

if ($form->isSubmitted() && $form->isValid()) {
    $data = $form->getData();
}

echo (new HtmlRenderer())->renderForm($form->createView());
```

## Features

- cycle `handleRequest()` / `isSubmitted()` / `isValid()`
- contraintes `Required`, `Email`, `Length`, `Choice`, `Regex`, `Min`, `Max`, `Range`, `Url`, `Count`, `Callback`, `File`, `MimeType`, `MaxFileSize`
- `CollectionType`
- `FormTypeField`
- event dispatcher minimal
- mapping objet / tableau
- CSRF optionnel
- support historique pour les types de champs legacy


## Fieldsets

The modern facade preserves legacy-style fieldset grouping:

```php
use Iriven\PhpFormGenerator\FormGenerator;

$form = (new FormGenerator())
    ->open('profile')
    ->addFieldset(['legend' => 'Identity', 'description' => 'Public information'])
    ->addText('name')
    ->addEmail('email')
    ->endFieldset()
    ->addSubmit('save', ['label' => 'Save'])
    ->getForm();
```

Nested fieldsets are supported by calling `addFieldset()` again before `endFieldset()`.


## Fieldsets au niveau bas niveau

Le `FormBuilder` supporte désormais nativement les sections `fieldset`, sans passer par la façade rapide.

```php
use Iriven\PhpFormGenerator\Application\FormFactory;
use Iriven\PhpFormGenerator\Domain\Field\EmailType;
use Iriven\PhpFormGenerator\Domain\Field\TextType;

$builder = (new FormFactory())->createBuilder('profile');

$form = $builder
    ->addFieldset([
        'legend' => 'Identity',
        'description' => 'Primary profile information',
        'attr' => ['class' => 'panel'],
    ])
    ->add('name', TextType::class, ['label' => 'Nom'])
    ->add('email', EmailType::class, ['label' => 'Email'])
    ->endFieldset()
    ->getForm();
```

Les fieldsets peuvent être imbriqués. Ils sont conservés dans la structure du formulaire et rendus même si aucun champ n'est encore ajouté au moment de leur déclaration.
