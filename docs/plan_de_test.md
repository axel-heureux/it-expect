# 📋 Plan de Test & Stratégie - Project ItExpect

## 1. Introduction et Objectifs

Ce document définit la stratégie et le plan de test applicables au projet **ItExpect**. L'application est un module de gestion d'items (nom, prix, stock) développé en **PHP natif selon une architecture MVC monolithique** (Router / Controller / Model / View), avec persistance via **PDO/MySQL**.

Il vise à cadrer la mise en œuvre des tests unitaires, d'intégration et bout en bout (E2E) pour valider :
* la fiabilité des règles de validation métier (`Validator`) ;
* la correction des opérations CRUD sur les items (`ItemRepository`) ;
* le bon comportement du contrôleur applicatif (`ItemController`) ;
* le parcours utilisateur complet (ajout, consultation, suppression) via l'interface Bootstrap.

---

## 2. Périmètre des Tests

### 2.1. Inclus dans le périmètre

* Validation des données de saisie : champ obligatoire, format numérique, longueur maximale (`Core\Validator`).
* Hydratation et accesseurs de l'entité `Item`.
* Opérations de persistance : création, lecture (liste et par ID), suppression (`Model\ItemRepository`).
* Comportement du contrôleur `ItemController` : affichage de la liste, ajout (cas nominal et cas d'erreur), suppression, et distinction requête classique / requête AJAX (`X-Requested-With`).
* Parcours utilisateur dans le navigateur : ouverture de la modale, soumission du formulaire, affichage des erreurs, suppression avec confirmation, mise à jour dynamique de la liste.
* Cas d'affichage particuliers : rupture de stock, liste vide, message de confirmation après ajout.

### 2.2. Exclus du périmètre

* Authentification et gestion des droits utilisateurs (non implémentées dans la version actuelle).
* Modification (édition) d'un item existant (non implémentée — seules la création et la suppression le sont).
* Tests de charge / performance.
* Tests de sécurité approfondis (audit de sécurité, pentest) — un contrôle de base (échappement `htmlspecialchars`, requêtes préparées PDO) est vérifié mais ne fait pas l'objet d'une campagne dédiée à ce stade.
* Compatibilité multi-navigateurs exhaustive (le plan cible Chrome et Firefox à jour uniquement).

---

## 3. Typologie des Tests & Stratégie

### 3.1. Tests unitaires — PHPUnit

Ciblent les classes sans dépendance externe (base de données, HTTP) :

| Composant | Ce qui est testé |
|---|---|
| `Core\Validator` | Chaque règle (`required`, `numeric`, `maxLength`, `minLength`, `email`) isolément, combinaisons de règles, messages d'erreur |
| `Model\Item` | `hydrate()`, getters/setters, trim automatique du nom |

### 3.2. Tests d'intégration — PHPUnit

Ciblent les composants qui interagissent avec une dépendance externe, sur un environnement de test isolé (SQLite en mémoire ou base MySQL de recette dédiée) :

| Composant | Ce qui est testé |
|---|---|
| `Model\ItemRepository` | `findAll()`, `findById()`, `save()` (insertion et mise à jour), `deleteById()` |
| `Controller\ItemController` | Comportement de `store()` et `destroy()` avec un `ItemRepository` mocké (nécessite l'injection de dépendance dans le constructeur du contrôleur), réponse JSON en contexte AJAX |

> **Prérequis technique** : `ItemController` instancie actuellement `ItemRepository` directement dans son constructeur. Il est recommandé de permettre l'injection (`__construct(?ItemRepository $repository = null)`) pour rendre ces tests possibles sans base réelle.

### 3.3. Tests End-to-End — Cypress

Ciblent le parcours utilisateur complet dans un navigateur, sur un environnement de recette avec base de données réinitialisable :

* Affichage de la liste au chargement.
* Ajout d'un item valide via la modale (mode AJAX) et mise à jour de la liste sans rechargement complet.
* Affichage des messages d'erreur par champ en cas de données invalides.
* Suppression d'un item avec confirmation, et disparition de la carte sans rechargement.
* Affichage de « Rupture de stock » et du message de liste vide.

### 3.4. Répartition indicative de l'effort (pyramide de test)

```
        /\
       /E2E\        ~15 % — Cypress (parcours critiques uniquement)
      /------\
     /Intégra-\     ~30 % — PHPUnit + base de test
    /   tion   \
   /------------\
  /   Unitaire   \  ~55 % — PHPUnit (Validator, Item)
 /----------------\
```

---

## 4. Environnements de Test

| Environnement | Usage |
|---|---|
| Local (dev) | Exécution des tests unitaires et d'intégration pendant le développement |
| Intégration continue (CI) | Exécution automatique de la suite PHPUnit à chaque push/PR |
| Recette | Exécution manuelle du cahier de recettes et des tests Cypress, base de données dédiée et réinitialisable |

---

## 5. Outils et Frameworks

| Outil | Rôle |
|---|---|
| PHPUnit | Tests unitaires et d'intégration PHP |
| SQLite (en mémoire) | Base de test légère pour les tests d'intégration du repository |
| Cypress | Tests end-to-end sur l'interface |
| Xdebug / rapport de couverture PHPUnit | Suivi de la couverture de code |

---

## 6. Critères d'Entrée et de Sortie

**Critères d'entrée** (avant de démarrer la recette) :
* L'ensemble des tests unitaires et d'intégration PHPUnit passent en CI.
* L'environnement de recette est déployé et accessible, base de données réinitialisée.

**Critères de sortie** (fin de campagne) :
* 100 % des scénarios du cahier de recettes exécutés.
* Aucune anomalie bloquante ou majeure ouverte sur le périmètre inclus.
* Couverture de code PHPUnit ≥ 80 % sur `Validator`, `Item` et `ItemRepository`.

---

## 7. Livrables

* Suite de tests PHPUnit (`tests/Unit`, `tests/Integration`).
* Suite de tests Cypress (`cypress/e2e`).
* Cahier de recettes (`cahier_de_recettes.md`) complété avec les résultats d'exécution.
* Rapport de couverture de code.

---

## 8. Rôles et Responsabilités

| Rôle | Responsabilité |
|---|---|
| Développeur | Écriture et maintenance des tests unitaires et d'intégration |
| Testeur / QA | Exécution du cahier de recettes, écriture et exécution des tests Cypress |
| Chef de projet | Validation des critères de sortie, arbitrage sur les anomalies |

---

## 9. Risques et Mitigations

| Risque | Mitigation |
|---|---|
| Couplage fort entre `ItemController` et `ItemRepository` empêchant les tests isolés | Introduire l'injection de dépendance dans le constructeur du contrôleur |
| Tests Cypress dépendants de l'état de la base (pollution entre exécutions) | Script de réinitialisation (seed/reset) exécuté avant chaque run |
| Divergence entre le comportement AJAX et non-AJAX du contrôleur non testée | Couvrir explicitement les deux chemins (`X-Requested-With` présent / absent) dans les tests d'intégration |