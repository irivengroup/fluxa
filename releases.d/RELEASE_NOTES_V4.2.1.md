[↑ Retour aux release notes](../RELEASE_NOTES.md)

> Breadcrumb: [Release Notes](../RELEASE_NOTES.md) / RELEASE_NOTES_V4.2.1.md

# V4.2.1 – Maintenance stable

## Positionnement
V4.2.1 est un patch de maintenance de la ligne stable V4.2.x.

## Objectifs
- préserver la stabilité de l’API publique
- durcir le runtime existant
- renforcer la non-régression
- clarifier la politique de maintenance et le workflow de correction

## Vérifications recommandées
```bash
composer dump-autoload -o
composer validate:full
composer test:coverage
vendor/bin/phpunit --colors=never
vendor/bin/phpstan analyse src tests
```

[↑ Retour aux release notes](../RELEASE_NOTES.md)
