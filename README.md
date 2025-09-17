# GazApp - Application de Distribution de Gaz Domestique

## Description

GazApp est une application web monolithique développée avec Laravel 12, Blade et TailwindCSS pour digitaliser la commande et la distribution de gaz domestique. L'application propose des dashboards sécurisés pour l'administration et la gestion des vendeurs.

## Fonctionnalités Principales

### 🏠 Côté Client

-   **Page de visite publique** : Présentation de l'application et possibilité de commander
-   **Formulaire de commande** : Champs standards + géolocalisation obligatoire
-   **Paiement en ligne** : Mobile Money, carte bancaire ou espèces apres la reception
-   **Téléchargement de reçu** : Reçus numériques après paiement validé
-   **Redirection dynamique** : Attribution automatique au vendeur le plus proche
-   **Services de sécurité** : Signalement direct à la police et aux pompiers

### 🏪 Côté Vendeur

-   **Dashboard vendeur** : Gestion des commandes et livraisons
-   **Gestion des stocks** : Mise à jour en temps réel
-   **Historique des paiements** : Suivi des transactions
-   **Validation des livraisons** : Confirmation et suivi

### 👨‍💼 Côté Administrateur

-   **Dashboard admin sécurisé** : Middleware d'authentification et d'autorisation
-   **CRUD complet** : Gestion des vendeurs, clients, commandes et stocks
-   **Supervision des transactions** : Rapports et statistiques
-   **Gestion des ruptures de stock** : Alertes et notifications

## Architecture Technique

### Backend

-   **Laravel 12** : Framework PHP moderne
-   **MySQL** : Base de données relationnelle
-   **Eloquent ORM** : Gestion des modèles de données
-   **Middleware personnalisés** : Sécurité et autorisation

### Frontend

-   **Blade Templates** : Moteur de template Laravel
-   **TailwindCSS** : Framework CSS utilitaire
-   **JavaScript Vanilla** : Interactions côté client
-   **Responsive Design** : Compatible mobile et desktop

### Services Intégrés

-   **Géolocalisation** : Calcul de distance et attribution automatique
-   **Paiement Mobile Money** : Intégration API de paiement
-   **Génération de reçus** : PDF automatiques
-   **Services de sécurité** : Signalement police/pompiers

## Installation

### Prérequis

-   PHP 8.2+
-   Composer
-   MySQL 8.0+
-   Node.js & NPM

### Étapes d'installation

1. **Cloner le projet**

```bash
git clone <repository-url>
cd Gaz-Application
```

2. **Installer les dépendances**

```bash
composer install
npm install
```

3. **Configuration de l'environnement**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configuration de la base de données**

```bash
# Modifier le fichier .env avec vos paramètres de base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gaz_application
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Exécuter les migrations et seeders**

```bash
php artisan migrate
php artisan db:seed
```

6. **Démarrer l'application**

```bash
php artisan serve
```

L'application sera accessible sur `http://localhost:8000`

## Comptes de Test

Après l'installation, vous pouvez utiliser ces comptes de test :

### Administrateur

-   **Email** : admin@gazapp.com
-   **Mot de passe** : password

### Vendeurs

-   **Email** : vendeur1@gazapp.com
-   **Mot de passe** : password

-   **Email** : vendeur2@gazapp.com
-   **Mot de passe** : password

### Client

-   **Email** : client@gazapp.com
-   **Mot de passe** : password

## Structure du Projet

```
app/
├── Http/Controllers/     # Contrôleurs de l'application
├── Models/              # Modèles Eloquent
├── Services/            # Services métier (Paiement, Géolocalisation)
└── Http/Middleware/     # Middlewares personnalisés

database/
├── migrations/          # Migrations de base de données
└── seeders/            # Seeders pour les données de test

resources/
├── views/              # Templates Blade
│   ├── layouts/        # Layouts principaux
│   ├── commandes/      # Vues des commandes
│   ├── stocks/         # Vues des stocks
│   └── ...
└── css/               # Styles CSS

routes/
└── web.php            # Routes de l'application
```

## Fonctionnalités Détaillées

### Système de Commandes

-   Création de commandes avec géolocalisation obligatoire
-   Attribution automatique au vendeur le plus proche
-   Gestion des statuts (en attente, confirmée, en cours, livrée, annulée)
-   Suivi en temps réel des commandes

### Gestion des Stocks

-   Suivi des quantités disponibles
-   Alertes de rupture de stock
-   Mise à jour automatique lors des commandes
-   Gestion des prix par vendeur

### Système de Paiement

-   Intégration Mobile Money (Orange, MTN, Moov)
-   Paiement par carte bancaire
-   Paiement en espèces
-   Génération automatique de reçus

### Services de Sécurité

-   Signalement direct à la police en cas de non-livraison
-   Contact direct avec les pompiers en cas d'urgence
-   Traçabilité complète des signalements
-   Réponse automatique des services

### Géolocalisation

-   Calcul de distance entre client et vendeurs
-   Attribution automatique du vendeur le plus proche
-   Validation des adresses de livraison
-   Estimation des temps de livraison

## Règles Métier

1. **Géolocalisation obligatoire** : Toute commande doit inclure des coordonnées GPS
2. **Reçus numériques** : Générés uniquement après confirmation du paiement
3. **Redirection dynamique** : Le système attribue toujours le vendeur le plus proche avec du stock
4. **Sécurité** : Accès aux services d'urgence via boutons simples
5. **Protection des accès** : Middleware sur tous les dashboards sensibles

## Technologies Utilisées

-   **Backend** : Laravel 12, PHP 8.2+, MySQL
-   **Frontend** : Blade, TailwindCSS, JavaScript
-   **Services** : Géolocalisation, Mobile Money API
-   **Sécurité** : Middleware Laravel, CSRF Protection
-   **Développement** : Composer, NPM, Vite

## Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## Support

Pour toute question ou problème, veuillez ouvrir une issue sur le repository GitHub.

---

**GazApp** - Simplifiez l'achat de gaz en ligne ! 🚀
