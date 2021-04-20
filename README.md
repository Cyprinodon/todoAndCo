ToDoList
========

## Audit
Lien vers le rapport d'audit de code:
https://docs.google.com/document/d/1FQvzCrBr0VECvA3rOjpMZvqDFHON0etKrPxtdIrDMBI/edit?usp=sharing

Lien vers la documentation technique de l'authentification:
https://docs.google.com/document/d/1NygJMItwXbsy1ZBeI4YRL8kcianZUeZ13OkSqkHjXaw/edit?usp=sharing

## Contribution
Vous désirez contribuez ? Vous pouvez lire le document contributing.md, présent à la racine du projet pour vous familiariser avec les règles du projet.

## Introduction
**ToDo & Co** représente le projet 8 du parcours *développeur Web Symfony*. Il demande la mise à niveau et la maintenance d'un projet symfony dépassé.
    - Ecriture d'un Rapport d'Audit
    - Mise à niveau du projet en version 'Long Term Support'

## Installation
  1. Récupérer une copie du projet
      - Aller sur (https://github.com/Cyprinodon/todoAndCo)
      - Cliquer sur le bouton contextuel **Code** dans la barre de navigation de fichier
      - Dans la liste déroulante, sélectionner **Download ZIP**
      - Sauvegarder le fichier dans l'emplacement de votre choix
      - Faire un clic droit sur l'archive et choisissez **Extraire vers...**
      - Choisir l'emplacement qui vous convient
      
  2. Installer la base de données
      - Ouvrir la console en ligne de commande de votre choix et déplacez-vous jusque dans le dossier racine du projet *(commande `cd <chemin>` sur windows)* 
      - Créer la base de données en entrant la commande `bin/console doctrine:database:create`
      - Mettre à jour la structure de la base de données en entrant la commande `bin/console doctrine:migrations:migrate`
      - Charger le jeu de fausses données dans la base de données en entrant la commande `bin/console doctrine:fixtures:load`
      
  3. Configurer les variables d'environnement
      - Dans le fichier .env, ajouter/modifier les variables suivantes:
          * APP_ENV => mode d'exécution de l'application. Mettez "prod" pour passer en production, "test" pour passer en environnement de test et "dev" pour passer en mode debug
          * DATABASE_URL => les identifiants de la base de données: `mysql://user:password@127.0.0.1:3306/db_name?serverVersion=5.7` où `user` corresponds au nom du compte ayant accès à la base de données, `password` corresponds au mot de passe et `db_name` au nom de la base de données
          
  4. L'application est déployée

## Utilisation
Si vous n'êtes pas connecté, l'application vous redirigera immanquablement sur *(domain)/login* où vous pourrez créer un nouvel utilisateur. Une fois connecté, vous pourrez naviguer sur les routes suivantes :
- La route *(domain)/logout* vous permet de vous déconnecter.
- La route *(domain)/tasks* affiche la liste des tâches.
- La route *(domain)/tasks/create* affiche le formulaire de création de tâche en GET et créé la tâche en POST.
- La route *(domain)/tasks/{id}/delete* supprime la tâche numéro *{id}*. (seulement si l'utilisateur enregistré est administrateur ou auteur de la tâche.)
- La route *(domain)/tasks/{id}/toggle* coche/décoche la tâche numéro *{id}* comme étant complétée.
- La route *(domain)/tasks/{id}/edit* affiche le formulaire de modification de tâche en GET et modifie la tâche en POST.
- La route *(domain)/users* affiche la liste des utilisateurs de l'application. (seul un administrateur peut y accéder)
- La route *(domain)/users/{id}/edit* affiche le formulaire d'édition de l'utilisateur numéro *{id}* en GET et modifie l'utilisateur en POST. (Seul un administrateur peut y accéder.)
