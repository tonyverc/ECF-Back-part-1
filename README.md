# Bibliothèque

Ce repo contient une application de gestion d'emprunts de livres pour une bibliothèque.
Il s'agit d'un projet d'évaluation pour la promo 11.

## Prérequis

- Linux, MacOS ou Windows 
- Bash
- PHP 8
- Composer
- Symfony-cli
- MariaDB
- Docker (optionnel)

## Installation

```
git clone https://github.com/jumariaco/bibliotheque
cd bibliotheque
composer install
```

Créez une base de données et un utilisateur dédié pour cette base de données.

## Configuration

Créez un fichier `.env.local`à la racine du projet :

```
APP_ENV=dev
APP_DEBUG=true
APP_SECRET=8979cfa061d78afaafe3a2ddbdfca1f5
DATABASE_URL="mysql://*Nom de la base de données*:*mot de passe*@127.0.0.1:3306/*Nom du compte utilisateur*?serverVersion=MariaDB*version de MariaDB*&charset=utf8mb4"
```

Pensez à changer la variable `APP_SECRET`, ainsi que le nom de la base de données, du compte utilisateur, les codes d'accès et la version de MariaDB dans la variable `DATABASE_URL` en remplaçant les éléments *...*.

**ATTENTION : `APP_SECRET`doit être une chaîne de caractères de 32 caractères en hexadecimal.**

## Migrations et fixtures

Pour que l'application soit utilisable, vous devez créer le schéma de base de données et charger des données :

```
bin/dofilo.sh
```

## Utilisation

Lancez le serveur web de développement : 

```
symfony serve
```

Puis ouvrez la page suivante : [https://localhost:8000](https://localhost:8000)

Personnalisez la fin de l'URL selon le choix des requêtes d'accès aux données :

Pour les requêtes sur la classe User, ouvrez la page suivante : [https://localhost:8000/test/user](https://localhost:8000/test/user).
Pour les requêtes sur la classe Livre, ouvrez la page suivante : [https://localhost:8000/test/livre](https://localhost:8000/test/livre).
Pour les requêtes sur la classe Emprunteur, ouvrez la page suivante : [https://localhost:8000/test/emprunteur](https://localhost:8000/test/emprunteur).
Pour les requêtes sur la classe Emprunt, ouvrez la page suivante : [https://localhost:8000/test/emprunt](https://localhost:8000/test/emprunt).


## Mentions légales

Ce projet est sous licence MIT.

La licence est disponible ici [MIT LICENCE](LICENCE).