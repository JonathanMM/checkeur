<?php
session_start();
require_once("config_mysql.php");
require_once("fonctions.php");
if(!isset($_SESSION['co']) || $_SESSION['co'] === false)
{
    header('location: connexion.php');
}
?>