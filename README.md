# PhpFormGenerator V3.4

Framework de formulaires PHP orienté enterprise.

## Capacités V3.4

- formulaires imbriqués
- collections récursives
- fieldsets
- transformers réels
- validation
- mapping array / objet
- thèmes HTML `default`, `bootstrap5`, `tailwind`
- compatibilité avec les field types historiques principaux

## Exemple

```php
use Iriven\PhpFormGenerator\Application\FormFactory;
use Iriven\PhpFormGenerator\Infrastructure\Http\ArrayRequest;
use Iriven\PhpFormGenerator\Infrastructure\Security\NullCsrfManager;
use Iriven\PhpFormGenerator\Presentation\Html\HtmlRenderer;
use Iriven\PhpFormGenerator\Presentation\Html\Theme\Bootstrap5Theme;
use Iriven\PhpFormGenerator\Tests\Fixtures\InvoiceType;

$factory = new FormFactory(csrfManager: new NullCsrfManager());
$form = $factory->create(InvoiceType::class, [
    'customer' => ['name' => 'Alice'],
]);

$form->handleRequest(new ArrayRequest('POST', [
    'form' => [
        'customer' => ['name' => 'Alice'],
        'issuedAt' => '2026-04-13 10:30',
        'items' => [
            ['label' => 'Design', 'quantity' => '2', 'price' => '100.50']
        ],
    ]
]));

$renderer = new HtmlRenderer(new Bootstrap5Theme());
echo $renderer->renderForm($form->createView());
```
