# 📦 InventoryManager

**InventoryManager** est une application web développée en PHP (avec Bootstrap pour le frontend) qui permet la gestion complète des entrepôts, des produits, des stocks ainsi que des utilisateurs.
### 🧪 Environnement de développement recommandé

- L'application fonctionne en **local** via n'importe quel environnement PHP/MySQL.  
Pour une configuration rapide et flexible, il est **recommandé d'utiliser [Devilbox](https://devilbox.org/)** qui fournit une stack complète (PHP, MySQL, Apache/Nginx, etc.).

### 🧩 Base de données

Avant de lancer l’application, tu dois importer le script SQL fourni dans le dossier `/database` (ex. : `inventory_schema.sql`).

Ce script :
- crée toutes les tables nécessaires (utilisateurs, produits, entrepôts, historiques…),
- insère un **compte administrateur par défaut** : email:admin@example.com, mdp:admin
---

## 🚀 Fonctionnalités principales

### 🔐 Authentification & Gestion des utilisateurs
- Connexion sécurisée avec rôles (`Admin`, `Employé`)
- Création, modification et suppression d'utilisateurs
- Attribution d’un entrepôt à chaque employé

### 🏢 Gestion des entrepôts
- Ajout, modification et suppression d'entrepôts
- Visualisation des stocks par entrepôt

### 📦 Gestion des produits & inventaire
- Création de produits avec différents types
- Attribution de quantités de produits par entrepôt
- Suivi des mouvements de stock (entrées/sorties)
- Historique complet des mouvements

---

## 🛠️ Technologies utilisées

- **PHP** (backend)
- **MySQL** (base de données)
- **Bootstrap 5** (frontend)
- **HTML/CSS**
- Architecture simple (pas de framework JS avancé comme React)

---

### 🧱 Architecture du projet

- Le fichier principal est **`dashboard.php`**, qui sert de **point d’entrée unique** à l’application.
- Toute la logique de navigation est gérée avec une **structure en `switch()` sur `$_GET['page']`**, ce qui permet de charger dynamiquement les différentes sections :
  - `?page=products` → affiche les produits
  - `?page=warehouses` → affiche les entrepôts
  - `?page=history` → affiche l’historique, etc.
- Chaque section est incluse à l’aide de  `require_once`

### 💡 Approche Single Page côté serveur

l'application fonctionne comme une **Single Page Application côté serveur** :

- L’interface reste sur une **seule page principale (`dashboard.php`)**
- Aucun rechargement vers d'autres fichiers PHP (ex : pas de `products.php`, `users.php` directs)
- L’affichage est **dynamique**, généré selon les actions de l’utilisateur (formulaires, boutons)

