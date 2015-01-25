# Checkeur

* Auteur : JonathanMM
* Licence : GPL 3+
* Description : Site permettant à des personnes d'indiquer qu'ils se sont croisés à l'aide de QRCode. Un système de point de réputation est en place. Les inscriptions sont limités aux utilisateurs du forum de Nolife.

## Pré-requis

* Serveur web (testé sur apache2 avec php5.x dessus)
* Base de données MySQL

## Installation

1. Executer install.sql sur votre base de données MySQL

2. Insérer les identifiants de connexion à votre base de données dans le fichier config_mysql.php

3. Le fichier mp.txt est a mettre en lecture-écriture, ainsi que le dossier images/photos

4. Enjoy :)

## Notas

* Dans config_mysql.php, une constante BDD_PREFIXE est déclaré, mais n'est jamais utilisé.
* Il se peut qu'il reste des http://checkeur.nocle.fr en dur dans le code. C'est mal, je sais.
* Ce script a été écrit en 2012, ne l'oubliez pas :)
* Initialement, ce site est prévu uniquement pour les gens du forum de Nolife. Ainsi, lors d'une inscription, un message est généré dans le fichier mp.txt et l'administrateur doit l'envoyer par MP à la personne tentant de s'enregistrer. Puis, l'admin doit vider le fichier mp.txt.
* De même, lors de l'inscription, le site va tenter de récupérer des infos sur le forum de Nolife, comme la date d'inscription ou le nombre de message de l'utilisateur.
* Aucune maintenance n'est prévu pour ce code, vous l'utilisez donc à vos risques et périls. Néanmoins, si des gens veulent modifier le code et l'améliorer, n'hésitez pas, forkez le ;) Si des choses sont utiles, je pourrais envisager de les remonter dans la branche master :)