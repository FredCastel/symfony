# Commandes

## Symfony


```console
php bin/console make:entity
```

## Doctrine

commande pour re-construire la base de donnée Doctrine

```console
# dev
clear
php bin/console doctrine:database:drop --env=dev --force 
php bin/console doctrine:database:create --env=dev
php bin/console doctrine:schema:update --env=dev --force
php bin/console doctrine:fixtures:load --env=dev --group=main -n
```

```console
# test
clear
php bin/console doctrine:database:drop --env=test --force 
php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:update --env=test --force
php bin/console doctrine:fixtures:load --env=test --group=main -n
# php bin/console hautelook:fixtures:load --env=test -n
```

## cache

effacer le cache,
necessaire dès qu'on ajoute ou modifie les services

```console
clear
php bin/console cache:clear
php bin/console cache:clear --env=test
```

## DDD Maker
json tools
https://bjdash.github.io/JSON-Schema-Builder/

générer à partir du fichier application.json
toutes les classes necessaires à paritr des modèles
```console
php bin/console make:ddd:full
php bin/console make:ddd:domain
php bin/console make:ddd:application
php bin/console make:ddd:doctrine
php bin/console make:ddd:doctrine_entity
php bin/console make:ddd:doctrine_maker
php bin/console make:ddd:doctrine_repository
php bin/console make:ddd:doctrine_event_hander
php bin/console make:ddd:api
```

## PhpUnit

```console
php bin/phpunit
php bin/phpunit tests/Banking/Infrastructure/ApiPlatform/BankWriterApiTest.php
php bin/phpunit tests/Banking/Infrastructure/ApiPlatform/BankReaderApiTest.php
```

# Docker

Construire ou Reconstruire (long)
```console
docker-compose build
docker compose build --no-cache
docker compose up --pull always -d --wait
```

Lancer
```console
docker-compose up
```
## Terminal Docker

pour lancer les commandes doctrine ouvrir le terminal du conteneur php-1
puis saisir les commande php bin....

pour se connecter depuis vscode sur la base de donnée utiliée
 - Host localhost
 - Port celui donné par docker sur le conteneur database-1

activer touches fleches pour l'historique
```console
/bin/bash
```

Méthode 1 — Terminal intégré VS Code (la plus simple)

Ouvre le terminal dans VS Code
👉 `Ctrl + `` (ou Terminal → New Terminal)

Liste les conteneurs Docker :

docker ps


Tu verras quelque chose comme :

CONTAINER ID   IMAGE        NAMES
abc123         php:8.2      php-container
def456         mysql:8.0    db-container


Entre dans le conteneur PHP :

docker exec -it gwinver02-php-1 bash

# composer
regénérer autoload file quand on ajoute un namespace
ajouter namespace dans composer.json


```console
composer dump-autoload
```

# doctrine
ajouter namespace dans doctrine.yaml

# api platform
ajouter namespace dans api_platform.php

# debug

```console
php bin/console debug:router
php bin/console debug:autowiring
php bin/console debug:container
php bin/console debug:container _Mock --env=test
```

# traduction

utiliser https://poedit.net/
avec gettext() 

Tutoriel PHP : Internationaliser avec gettext
[![Tutoriel PHP : Internationaliser avec gettext](https://img.youtube.com/vi/5OY8O7Qt24w/0.jpg)](https://www.youtube.com/watch?v=5OY8O7Qt24w)

# Achitecture

## depot git

templates
- https://github.com/Nikoms/clean-architecture-example
- https://github.com/mtarld/apip-ddd
- https://github.com/CodelyTV/php-ddd-example

exemple Hexagonal Architecture, DDD & CQRS in PHP 
    https://github.com/CodelyTV/php-ddd-example

# Front-end

## Vite

https://symfony-vite.pentatrion.com/fr/
https://grafikart.fr/tutoriels/vitejs-symfony-1895
https://vuejs.org/guide/introduction.html

## npm

trouver la config locale
```console
npm config get userconfig
```
lancer le serveur
```console
npm run dev
```

## videos tuto

CQRS, Fonctionnel, Event Sourcing & Domain Driven Design - Arnaud Lemaire - PHP Tour 2018<br>
https://afup.org/talks/2628-cqrs-fonctionnel-event-sourcing-domain-driven-design
[![CQRS, Fonctionnel, Event Sourcing & Domain Driven Design - Arnaud Lemaire - PHP Tour 2018](https://img.youtube.com/vi/qBLtZN3p3FU/0.jpg)](https://www.youtube.com/watch?v=qBLtZN3p3FU)

repository pattern<br>
https://blog.mnavarro.dev/the-repository-pattern-done-right


