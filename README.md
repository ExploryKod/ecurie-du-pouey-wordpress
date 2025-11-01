<a name="readme-top"></a>

<div align="center">
  <h3 align="center"></h3>
  
  <p align="center">
    Site vitrine "Élevage du Pouey" - 2024
    <br/>
    <a href="#démarrage-en-local-avec-docker-compose">Docker (Recommandé)</a>
    -
    <a href="#installation-classique">Installation classique</a>
    -
    <a href="#fonctionnalities">Fonctionnalités</a>
    -
    <a href="#technologies">Technologies</a>
  </p>
</div>

# Présentation

Bienvenue sur le projet **Élevage du Pouey**, un site vitrine dédié à la présentation de l'élevage et de l'activité de l'écurie. Ce site met en lumière les chevaux et les services de qualité proposés par l'Élevage du Pouey, situé au cœur de la nature. À travers une interface simple et élégante, les visiteurs peuvent découvrir les activités de l'écurie, les chevaux disponibles, ainsi que les prestations proposées.

Ce guide vous accompagne dans l'installation et la configuration de ce site WordPress sur votre environnement local ou serveur distant.

> [!WARNING]
> **Important** : Ce site ne doit **PAS** être mis en ligne avec le nom "Écurie du Pouey" ou "Élevage du Pouey". Les écuries du Pouey existent réellement et possèdent déjà leur propre site web officiel. Ce projet est un **projet de hackathon** réalisé dans le cadre d'une semaine YMMERSION et n'est en ligne que sous forme de **démo/portfolio** à des fins pédagogiques et de démonstration.

> [!NOTE]  
> Ce projet a été réalisé dans le cadre d'une semaine YMMERSION en première année de Mastère chez YNOV.

# Démarrage en local avec Docker Compose

<p align="right">(<a href="#readme-top">Retour en haut</a>)</p>

> **Méthode recommandée** : Cette méthode est la plus simple et rapide pour démarrer le projet en local. Elle ne nécessite que Docker et Docker Compose installés sur votre machine.

### Prérequis Docker

Assurez-vous d'avoir installé sur votre machine :

- **Docker** : Version 20.10 ou supérieure
- **Docker Compose** : Version 2.0 ou supérieure (ou la commande `docker compose` intégrée)

### Configuration de l'environnement

1. Copiez le fichier d'exemple des variables d'environnement local :

```bash
cp env.local.example .env
```

2. Modifiez le fichier `.env` selon vos besoins. Les valeurs par défaut sont :

```bash
# Ports
WORDPRESS_PORT=10004
PHPMYADMIN_PORT=8080

# Configuration MySQL
MYSQL_ROOT_PASSWORD=root_password_here
MYSQL_DATABASE=wordpress_local
MYSQL_USER=wordpress_user
MYSQL_PASSWORD=wordpress_password
```

### Démarrage des conteneurs

Démarrez tous les services (base de données, WordPress, phpMyAdmin et wp-cli) :

```bash
docker compose up -d
```

Cette commande va créer et démarrer les conteneurs suivants :
- `db` : Base de données MySQL
- `wordpress` : Serveur WordPress (accessible sur http://localhost:10004)
- `phpmyadmin` : Interface phpMyAdmin (accessible sur http://localhost:8080)
- `wp-cli` : Conteneur wp-cli pour les commandes WordPress

### Import du dump SQL

Le projet contient un fichier `dump.sql` à la racine du projet. Pour l'importer dans la base de données Docker :

1. Attendez que le conteneur de base de données soit complètement démarré (quelques secondes)

2. Importez le dump SQL :

```bash
docker compose exec -T db mysql -u ${MYSQL_USER} -p${MYSQL_PASSWORD} ${MYSQL_DATABASE} < dump.sql
```

**Note** : Si vous utilisez ce dump, vous devrez mettre à jour les URLs dans la base de données avec wp-cli (voir section suivante).

### Mise à jour des URLs avec wp-cli

Si le dump SQL provient d'un environnement de production, vous devez mettre à jour les URLs pour qu'elles pointent vers votre environnement local.

1. Vérifiez les URLs actuelles :

```bash
docker compose exec wp-cli wp option get siteurl --allow-root
docker compose exec wp-cli wp option get home --allow-root
```

2. Effectuez le remplacement des URLs (remplacez `https://ancien-domaine.com` par votre ancien domaine de production) :

```bash
docker compose exec wp-cli wp search-replace 'https://ancien-domaine.com' 'http://localhost:10004' --allow-root
docker compose exec wp-cli wp search-replace 'ancien-domaine.com' 'localhost:10004' --allow-root
```

### Utilisation de wp-cli

Le conteneur `wp-cli` est disponible pour exécuter des commandes WordPress. Syntaxe générale :

```bash
docker compose exec wp-cli wp <commande> --allow-root
```

Exemples de commandes utiles :

```bash
# Vérifier la version de WordPress
docker compose exec wp-cli wp core version --allow-root

# Lister les plugins
docker compose exec wp-cli wp plugin list --allow-root

# Activer un plugin
docker compose exec wp-cli wp plugin activate nom-du-plugin --allow-root

# Lister les options WordPress
docker compose exec wp-cli wp option list --allow-root

# Vider le cache
docker compose exec wp-cli wp cache flush --allow-root
```

### Accès au site

Une fois les conteneurs démarrés et le dump SQL importé :

- **Site WordPress** : http://localhost:10004
- **phpMyAdmin** : http://localhost:8080
  - Utilisateur : valeur de `MYSQL_USER` dans votre `.env`
  - Mot de passe : valeur de `MYSQL_PASSWORD` dans votre `.env`

### Arrêt des conteneurs

Pour arrêter les conteneurs :

```bash
docker compose stop
```

Pour arrêter et supprimer les conteneurs (les données de la base de données sont conservées dans un volume) :

```bash
docker compose down
```

Pour supprimer également les volumes (ATTENTION : cela supprimera toutes les données de la base de données) :

```bash
docker compose down -v
```

<p align="right">(<a href="#readme-top">Retour en haut</a>)</p>

# Installation classique

<p align="right">(<a href="#readme-top">Retour en haut</a>)</p>

> **Alternative** : Si vous préférez installer WordPress de manière classique sans Docker, suivez cette section.

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre serveur local ou distant :

- **Serveur web** : Apache ou Nginx
- **PHP** : Version 8.3 ou supérieur (Recommandé 8.3.11)
- **Base de données** : MySQL 8 (Recommandé 8.0.16)
- **Git** : Pour cloner le dépôt du projet
- **Accès FTP/SSH** : Si vous travaillez sur un serveur distant

## Installation

### Cloner le dépôt

Clonez le dépôt GIT dans le répertoire de votre serveur local ou de votre hébergement distant :

```bash
git clone https://github.com/DevSkyLex/ecurie-du-pouey-wordpress.git
```

Accédez au dossier contenant le clone du dépôt GIT :

```bash
cd ecurie-du-pouey-wordpress
```

### Configurer les variables d'environnement

Copiez le fichier d'exemple des variables d'environnement (`.env.example`) et renommez-le en `.env`. Ce fichier contient toutes les configurations nécessaires pour votre environnement.

```bash
cp .env.example .env
```

Modifiez ensuite les variables d'environnement :

```bash
# Nom de la base de données
DB_NAME=nom_base_de_donnees

# Nom d'utilisateur de la base de données
DB_USER=nom_utilisateur

# Mot de passe de l'utilisateur de la base de données
DB_PASSWORD=mot_de_passe

# Hôte de la base de données (localhost si en local)
DB_HOST=localhost

# Charset de la base de données (recommandé : utf8)
DB_CHARSET=utf8

# Collation à utiliser (laisser vide pour la configuration par défaut)
DB_COLLATE=""
```

### Importer le dump de la base de données

Un dump de la base de données est fourni avec le projet. Pour l'importer :

1. Créez une nouvelle base de données **MySQL** sur votre serveur local ou distant. Vous pouvez le faire via un outil comme **phpMyAdmin** ou en ligne de commande :

```bash
mysql -u root -p -e "CREATE DATABASE <nom_base_de_donnees>;"
```

2. Importez le fichier de **dump SQL** dans votre base de données nouvellement créée. Le fichier de dump se trouve à la racine du projet (`dump.sql`) :

```bash
mysql -u <utilisateur> -p <nom_base_de_donnees> < dump.sql
```

### Finaliser la configuration

Utilisez les identifiants de connexion fournis pour accéder à l'administration WordPress et finaliser la configuration du site.





