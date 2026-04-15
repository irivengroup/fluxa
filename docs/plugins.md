# Plugins officiels

## Base plugins-ready

Le projet fournit maintenant une base officielle pour des plugins :

- `Application\FormPluginKernel`
- `Infrastructure\Registry\PluginRegistry`
- `Infrastructure\Registry\InMemoryFieldTypeRegistry`
- `Infrastructure\Registry\InMemoryFormTypeRegistry`
- `Infrastructure\Registry\BuiltinRegistries`

## Exemple d’initialisation

```php
$kernel = (new FormPluginKernel())
    ->register(new DemoPlugin());

$pluginRegistry = $kernel->plugins();
```

## Convention recommandée

Un plugin doit idéalement exposer :

- ses `FieldType`
- ses `FormType`
- ses extensions
- sa documentation dans `docs/`
