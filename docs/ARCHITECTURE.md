# Architecture

## Couches

- `Application`: factory, registry, orchestration
- `Domain`: contrats, formulaires, champs, contraintes, événements
- `Infrastructure`: HTTP, mapping, CSRF
- `Presentation`: rendu HTML

## Décisions

- les formulaires sont des agrégats qui gèrent état, données, validation et vue
- les champs sont décrits par des `FieldTypeInterface`
- le rendu HTML passe par une `FormView`
- la validation est indépendante du renderer
- le mapping est injectable


## Sections et fieldsets

Le `FormBuilder` conserve désormais une arborescence explicite des `fieldsets`. Cette structure est propagée au `Form`, puis convertie en `FormView` avant rendu HTML. Les champs restent mappés via `fieldset_path`, mais les sections existent aussi comme objets de structure afin de préserver l'ordre et de permettre le rendu de fieldsets vides ou imbriqués.
