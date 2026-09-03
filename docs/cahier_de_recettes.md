# 📄 Cahier de Recettes - Project ItExpect

## 1. Informations Générales
* **Nom du Projet** : ItExpect
* **Version** : 1.0.0
* **Auteur(s)** : HEUREUX Axel
* **Module couvert** : Gestion de la liste d'items (consultation, ajout, suppression)
* **Ticket associé** : ITEXP-1

---

## 2. Matrice des Cas d'Usage (Use Cases)

| ID | Titre | Acteur | Priorité | Statut |
|---|---|---|---|---|
| UC-01 | Consultation de la liste des items | Utilisateur | Haute | À tester |
| UC-02 | Ajout d'un item avec des données valides | Utilisateur | Haute | À tester |
| UC-03 | Ajout d'un item avec des données invalides (rejet) | Utilisateur | Haute | À tester |
| UC-04 | Suppression d'un item | Utilisateur | Haute | À tester |
| UC-05 | Cas d'affichage particuliers (rupture de stock / liste vide) | Utilisateur | Moyenne | À tester |

---

## 3. Fiches Détaillées des Cas de Test

---

### 🧪 Fiche de Test : UC-01 - Consultation de la liste des items

* **Objectif** : Vérifier que la page d'accueil affiche correctement les items enregistrés.
* **Acteur** : Utilisateur
* **Préconditions** : Au moins un item existe en base de données.
* **Données de test** : Items existants (nom, prix, stock).

| # | Étape | Résultat attendu |
|---|---|---|
| 1 | Accéder à la page d'accueil (`/`) | La page se charge et affiche « Liste des items » |
| 2 | Observer les cartes affichées | Chaque carte présente le nom, le prix (format `12,00 €`), le stock et l'ID |
| 3 | Vérifier l'ordre des cartes | Les items sont triés du plus récent au plus ancien (ID décroissant) |

* **Résultat obtenu** : ☐ Validé ☐ Non validé ☐ Non testé
* **Remarques** :

---

### 🧪 Fiche de Test : UC-02 - Ajout d'un item avec des données valides

* **Objectif** : Vérifier qu'un item est correctement créé et affiché après une saisie valide.
* **Acteur** : Utilisateur
* **Préconditions** : Être sur la page d'accueil.
* **Données de test** : Nom = « Clavier mécanique », Prix = « 49.90 », Stock = « 10 ».

| # | Étape | Résultat attendu |
|---|---|---|
| 1 | Cliquer sur « + Ajouter un item » | La modale d'ajout s'ouvre avec les champs Nom, Prix, Stock |
| 2 | Saisir les données de test et cliquer sur « Enregistrer » | La modale se ferme, aucune erreur ne s'affiche |
| 3 | Observer la liste | Une nouvelle carte apparaît en tête de liste avec « 49,90 € » et « 10 unité(s) » |

* **Résultat obtenu** : ☐ Validé ☐ Non validé ☐ Non testé
* **Remarques** :

---

### 🧪 Fiche de Test : UC-03 - Ajout d'un item avec des données invalides (rejet)

* **Objectif** : Vérifier que les règles de validation (`required`, `numeric`, `maxLength:100`) bloquent bien la création et affichent les bons messages.
* **Acteur** : Utilisateur
* **Préconditions** : Être sur la page d'accueil, modale d'ajout ouverte.
* **Données de test** :
  * Cas A — Nom vide, Prix = « 10 », Stock = « 5 »
  * Cas B — Nom = « Souris », Prix = « abc », Stock = « 5 »
  * Cas C — Nom = « Souris », Prix = « 10 », Stock = « cinq »
  * Cas D — Nom de plus de 100 caractères, Prix et Stock valides

| # | Étape | Résultat attendu |
|---|---|---|
| 1 | Soumettre le Cas A | Message « Ce champ est obligatoire. » sous le champ Nom, aucun item créé |
| 2 | Soumettre le Cas B | Message « Ce champ doit être un nombre. » sous le champ Prix, aucun item créé |
| 3 | Soumettre le Cas C | Message « Ce champ doit être un nombre. » sous le champ Stock, aucun item créé |
| 4 | Soumettre le Cas D | Message « Ce champ ne doit pas dépasser 100 caractères. » sous le champ Nom, aucun item créé |
| 5 | Vérifier la modale après chaque rejet | Les valeurs déjà saisies (hors champ en erreur) sont conservées dans le formulaire |

* **Résultat obtenu** : ☐ Validé ☐ Non validé ☐ Non testé
* **Remarques** :

---

### 🧪 Fiche de Test : UC-04 - Suppression d'un item

* **Objectif** : Vérifier qu'un item peut être supprimé et que la suppression est bien persistée.
* **Acteur** : Utilisateur
* **Préconditions** : Au moins un item existe dans la liste.
* **Données de test** : Un item existant quelconque.

| # | Étape | Résultat attendu |
|---|---|---|
| 1 | Cliquer sur « Supprimer » sur une carte | Une boîte de confirmation « Supprimer cet item ? » s'affiche |
| 2 | Confirmer la suppression | La carte disparaît immédiatement, sans rechargement complet de la page |
| 3 | Rafraîchir la page (F5) | L'item supprimé n'apparaît plus : la suppression est bien persistée en base |
| 4 | (Contre-test) Cliquer sur « Supprimer » puis « Annuler » | La carte reste affichée, aucune suppression n'a lieu |

* **Résultat obtenu** : ☐ Validé ☐ Non validé ☐ Non testé
* **Remarques** :

---

### 🧪 Fiche de Test : UC-05 - Cas d'affichage particuliers

* **Objectif** : Vérifier l'affichage de la rupture de stock et le message affiché quand la liste est vide.
* **Acteur** : Utilisateur
* **Préconditions** :
  * Pour la rupture de stock : un item avec Stock = 0 existe.
  * Pour la liste vide : la table `items` est vidée au préalable.

| # | Étape | Résultat attendu |
|---|---|---|
| 1 | Consulter la carte d'un item dont le stock est à 0 | La ligne Stock affiche « Rupture de stock » en rouge, à la place d'une quantité |
| 2 | Accéder à la page d'accueil sans aucun item enregistré | Le message « Aucun item trouvé. » s'affiche à la place de la grille de cartes |

* **Résultat obtenu** : ☐ Validé ☐ Non validé ☐ Non testé
* **Remarques** :

---

## 4. Synthèse de la campagne de recette

| Testeur | Date | UC validés | UC non validés | UC non testés |
|---|---|---|---|---|
| | | | | |