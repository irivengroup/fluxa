[↑ Retour aux release notes](../RELEASE_NOTES.md)

> Breadcrumb: [Release Notes](../RELEASE_NOTES.md) / RELEASE_NOTES_V3.9.5.md

# V3.9.5 – Stabilisation finale et préparation release

Cette version finalise la série 3.9.x avec une passe de stabilisation centrée sur la qualité, la cohérence d’architecture et la préparation d’une release propre.

## Points clés
- API publique alignée sur le nouveau standard uniquement
- couche legacy retirée
- décomposition des classes complexes principales
- couverture PHPUnit branchée pour Scrutinizer
- helpers réorganisés par responsabilité
- documentation et changelog harmonisés

## Vérifications recommandées avant tag
```bash
composer dump-autoload -o
vendor/bin/phpstan analyse src tests
vendor/bin/phpunit --colors=never
composer test:coverage
```

## Périmètre technique consolidé
- Construction de formulaire : `Application`, `Application\FormGenerator`
- Soumission : `Domain\Form`, `Domain\Form\Submission`
- Mapping / accès propriété : `Infrastructure\Mapping`, `Infrastructure\PropertyAccess`
- Catalogues / sécurité / options : `Infrastructure\Catalog`, `Infrastructure\Security`, `Infrastructure\Options`
- Rendu HTML : `Presentation\Html`, `Presentation\Html\Support`

[↑ Retour aux release notes](../RELEASE_NOTES.md)
