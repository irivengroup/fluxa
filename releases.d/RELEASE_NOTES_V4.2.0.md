[↑ Retour aux release notes](../RELEASE_NOTES.md)

> Breadcrumb: [Release Notes](../RELEASE_NOTES.md) / RELEASE_NOTES_V4.2.0.md

# V4.2.0 – Stable plugins-ready

## Positionnement
V4.2.0 constitue la publication stable de la ligne V4 avec support plugins-ready, runtime plugin branché, documentation d’exploitation consolidée et packaging finalisé.

## Points clés
- API builder stable
- API factory stable
- runtime plugin stable
- registries durcis
- tests d’intégration et de non-régression plugins
- wiki d’exploitation structuré dans `docs/`
- checklist de release et publication plugin documentées

## Contrat public
Les points d’entrée publics supportés sont documentés dans `docs/public-api.md`.

## Validation recommandée
```bash
composer dump-autoload -o
composer validate:full
composer test:coverage
composer rc:check
```

[↑ Retour aux release notes](../RELEASE_NOTES.md)
