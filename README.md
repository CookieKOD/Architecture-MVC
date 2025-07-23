# Application d'Actualités - Architecture MVC

## Description

Cette application web d'actualités a été restructurée selon le pattern architectural MVC (Modèle-Vue-Contrôleur) pour améliorer la maintenabilité, la lisibilité et l'extensibilité du code.

## Structure du projet

```
TP2-MVC/
├── config/
│   └── Database.php          # Configuration de la base de données
├── controllers/
│   ├── HomeController.php    # Contrôleur pour la page d'accueil
│   └── ArticleController.php # Contrôleur pour les articles
├── models/
│   ├── Article.php           # Modèle pour les articles
│   └── Categorie.php         # Modèle pour les catégories
├── views/
│   ├── layouts/
│   │   ├── header.php        # En-tête commun
│   │   └── footer.php        # Pied de page commun
│   ├── home/
│   │   └── index.php         # Vue de la page d'accueil
│   ├── article/
│   │   ├── show.php          # Vue d'affichage d'un article
│   │   └── create.php        # Vue de création d'article
│   └── error/
│       └── index.php         # Vue d'erreur
├── public/
│   ├── css/
│   │   └── style.css         # Styles CSS
│   ├── js/
│   │   └── app.js            # JavaScript
│   └── images/               # Images statiques
├── index.php                 # Point d'entrée principal
├── article.php               # Point d'entrée pour les articles
├── create-article.php        # Point d'entrée pour la création
├── .htaccess                 # Configuration Apache
└── README.md                 # Documentation
```

## Fonctionnalités

- **Affichage des articles** : Liste paginée des articles avec filtrage par catégorie
- **Lecture d'articles** : Affichage complet d'un article avec ses métadonnées
- **Création d'articles** : Formulaire de création avec validation
- **Gestion des catégories** : Système de catégorisation des articles
- **Interface responsive** : Compatible mobile et desktop
- **Gestion d'erreurs** : Pages d'erreur personnalisées

## Installation

1. **Prérequis**
   - Serveur web Apache avec mod_rewrite
   - PHP 7.4 ou supérieur
   - MySQL 5.7 ou supérieur
   - Extension PDO MySQL activée

2. **Configuration de la base de données**
   - Créer une base de données `mglsi_news`
   - Importer le schéma de base de données
   - Modifier les paramètres de connexion dans `config/Database.php`

3. **Déploiement**
   - Copier tous les fichiers dans le répertoire web
   - Vérifier les permissions d'écriture si nécessaire
   - Configurer le virtual host Apache

## Configuration

### Base de données

Modifiez les paramètres dans `config/Database.php` :

```php
private $host = 'localhost';
private $dbname = 'mglsi_news';
private $username = 'mglsi_user';
private $password = 'passer';
```

### Environnement

Pour passer en mode production, définissez la constante :

```php
define('PRODUCTION', true);
```

## Utilisation

### Pages principales

- **Accueil** : `index.php` - Liste des articles avec filtrage par catégorie
- **Article** : `article.php?id=X` - Affichage d'un article spécifique
- **Création** : `create-article.php` - Formulaire de création d'article

### API interne

Les modèles fournissent une API simple pour interagir avec les données :

```php
// Récupérer tous les articles
$articles = $articleModel->getAllArticles();

// Récupérer un article par ID
$article = $articleModel->getArticleById($id);

// Créer un nouvel article
$success = $articleModel->createArticle($titre, $contenu, $categorieId);
```

## Développement

### Ajouter une nouvelle fonctionnalité

1. **Créer le modèle** (si nécessaire) dans `models/`
2. **Créer le contrôleur** dans `controllers/`
3. **Créer les vues** dans `views/`
4. **Ajouter le point d'entrée** à la racine
5. **Mettre à jour les liens** dans les vues existantes

### Conventions de codage

- **Nommage** : PascalCase pour les classes, camelCase pour les méthodes
- **Documentation** : Commentaires PHPDoc pour toutes les méthodes publiques
- **Sécurité** : Échappement HTML avec `htmlspecialchars()`
- **Base de données** : Requêtes préparées obligatoires

## Sécurité

- Protection contre les injections SQL via PDO
- Échappement des données en sortie
- Validation des entrées utilisateur
- En-têtes de sécurité configurés
- Accès restreint aux fichiers sensibles

## Performance

- Mise en cache des ressources statiques
- Compression GZIP activée
- Optimisation des requêtes SQL
- Chargement conditionnel des ressources

## Maintenance

### Logs d'erreurs

En mode production, les erreurs sont loggées automatiquement. Consultez les logs du serveur web pour le débogage.

### Sauvegarde

Sauvegardez régulièrement :
- La base de données
- Les fichiers uploadés (si applicable)
- Les fichiers de configuration

## Support

Pour toute question ou problème, consultez la documentation ou contactez l'équipe de développement.

"# Architecture-MVC" 
