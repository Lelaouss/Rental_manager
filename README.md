# Rental Manager
Ce projet est un outil de gestion locative.
Son but est de vous aider dans la gestion de vos biens (appartements, maisons...) en vous permettant l'élaboration de divers documents (bail, état des lieux, situation charges, acte de caution solidaire...).

## Prise en main
Ces instructions vous permettront d'obtenir une copie du projet en cours d'exécution sur votre machine locale à des fins de développement et de test.

### Prérequis
- Connaître Symfony 4+ (https://symfony.com/doc/current/reference/requirements.html)
- PHP version >= 7.1.3 (https://www.php.net/manual/fr/install.php)
- MySQL version >= 5.6 (https://dev.mysql.com/downloads/installer/)
- Git (https://git-scm.com/book/fr/v1/D%C3%A9marrage-rapide-Installation-de-Git)
- Composer (https://getcomposer.org/download/)

### Installation
Télécharger le projet dans le dossier de votre choix :
```
git clone https://github.com/Lelaouss/rental_manager.git
```

Installation des dépendances depuis la racine du projet :
```
cd rental_manager
composer install
```

Renseigner les informations de connexion à la base de données dans le fichier .env se situant à la racine du projet.
Créer ensuite la base de données et sa structure :
```
php bin/console doctrine:database:create
php bin/console doctrine:database:import .\conception\BDD\script_bdd.sql
```

Mettre à jour la BDD en exécution les migrations :
```
php bin/console doctrine:migrations:migrate
```

Remplir la BDD de fausses données :
```
php bin/console doctrine:fixtures:load
```

Démarrer le serveur symfony :
```
php bin/console server:run
```

### Exécuter les tests
Afin d'exécuter les tests unitaires et fonctionnels :
```
vendor/bin/simple-phpunit
```

## Connexion
Le jeux de fausses données vous a créé un utilisateur avec un rôle d'admin. Vous pouvez donc vous connecter à la plateforme avec ces données :
- login : testeur
- mot de passe : manager*