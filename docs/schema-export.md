[↑ Retour au sommaire docs](index.md)

> Breadcrumb: [Docs](index.md) / Schema Export

# Schema Export

## Objectif
Fournir un export de schéma simple et directement exploitable.

## Exemple
```php
$factory = new FormFactory();
$builder = $factory->createBuilder('contact');
$builder->add('name', 'TextType', ['required' => true]);

$form = $builder->getForm();
$schema = (new FormSchemaManager(new ArraySchemaExporter()))->export($form);
```

## Hooks supportés
- `before_schema_export`
- `after_schema_export`

[↑ Retour au sommaire docs](index.md)
