# Contribuer au projet
## Conventions
### Git
- Les branches de fonctionnalité doivent être précédées du préfixe 'f_'.
- Les corrections de bug doivent se faire sur la branche 'bugfix'.
- L'ajout ou la modification d'éléments ayant un rapport avec la documentation du projet doit se faire sur la branche "documentation".
- Aucune modification ne doit être directement effectuée sur la branche 'master'. Celle-ci est en lecture seule.
- Toute fusion de branche doit se faire par le biais d'une pull request afin que lesdit changements puissent être vérifiés avant incorporation.
### PHP
- Le développement doit suivre les conventions de nommage psr-1 (https://www.php-fig.org/psr/psr-1/) et psr-2 (https://www.php-fig.org/psr/psr-2/).
- Les namespaces et la structure des dossiers doivent suivre les conventions psr-4 (https://www.php-fig.org/psr/psr-4/).
### Symfony
- Le projet s'efforce de respecter les bonnes pratiques symfony. Vous pouvez les consulter à cette adresse : (https://symfony.com/doc/current/best_practices.html)
## Récupérer le code source du projet
- Sur Github, faite un fork du projet (copie permettant les droits d'écriture) en cliquant sur le bouton "Fork" en haut à droite de la page du projet.
- Sur votre machine en local, clonez votre fork github
```
git clone https://github.com/YOUR_USERNAME/todoAndCo
```
- Déplacez-vous dans le dossier nouvellement cloné du projet
```
cd todoAndCo
```
- Puis, enregistrez le lien vers le répertoire distant
```
git remote add origin https://github.com/YOUR_USERNAME/todoAndCo
```
## Effectuer une pull request
### Synchroniser le répertoire d'origine avec votre fork
Afin de vous assurer que vous travaillez bien avec un projet à jour, assurez-vous de synchroniser régulièrement votre répertoire local avec le répertoire du projet d'origine.
- Enregistrez le lien vers le répertoire du projet d'origine
```
git remote add upstream https://github.com/Cyprinodon/todoAndCo
```
- Récupérez sur votre répertoire local toutes les branches et changements issus du répertoire du projet d'origine
```
git fetch upstream
```
- Fusionnez les modifications
```
git merge upstream/master
```
- Poussez les changements sur votre fork github
```
git push origin master
```

### Ajout d'une nouvelle fonctionnalité
- Commencez par créer une branche pour la nouvelle fonctionnalité sur laquelle vous désirez travailler. Une branche de fonctionnalité commence toujours par le préfixe.
```
git checkout -b f_ma_nouvelle_branche
```
- Effectuez un commit de vos changements sur cette branche
```
git commit -m "Ajoute : Nouvelle fonctionnalité"
```
- Poussez vos changements sur votre répertoire github
```
git push --set-upstream origin f_ma_nouvelle_branche
```
- Proposez une pull request de vos changements. Pour cela, allez sur le répertoire du projet d'origine et cliquez sur le bouton "pull request".
Sur la page "Compare" Cliquez sur "compare across fork", sélectionnez la branche master du répertoire d'origine dans le premier menu déroulant et la branche contenant votre fonctionnalité dans le second.
- Validez en cliquant sur "Create pull request".