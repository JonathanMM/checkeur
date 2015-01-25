<?php
$host = '';
$username = '';
$password = '';
$bdd_name = '';
define('BDD_PREFIXE', 'checker');

// Connexion a la base de données
mysql_connect($host,$username,$password);
mysql_select_db($bdd_name);
?>