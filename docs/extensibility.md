# Extensibilité

## Objectif

PhpFormGenerator V4.1.0 expose désormais une base officielle orientée extension et plugins.

## Points d’extension

- `FieldTypeRegistryInterface`
- `FormTypeRegistryInterface`
- `PluginInterface`
- `ExtensionRegistry`
- `FormPluginKernel`

## Créer un FieldType personnalisé

```php
final class SlugType extends TextType
{
}
```

Puis l’enregistrer via un plugin.

## Créer un FormType personnalisé

```php
final class NewsletterType implements FormTypeInterface
{
    public function buildForm($builder, array $options = []): void
    {
        $builder->add('email', EmailType::class, ['required' => true]);
    }

    public function configureOptions($resolver): void
    {
        $resolver->setDefaults(['method' => 'POST']);
    }
}
```

## Créer un plugin

```php
final class DemoPlugin implements PluginInterface
{
    public function registerFieldTypes(FieldTypeRegistryInterface $registry): void
    {
        $registry->register('slug', SlugType::class);
    }

    public function registerFormTypes(FormTypeRegistryInterface $registry): void
    {
        $registry->register('newsletter', NewsletterType::class);
    }

    public function registerExtensions(ExtensionRegistry $registry): void
    {
    }
}
```
