<?php
include('include_haut.php');
if(!isset($_GET['id']) || intval($_GET['id']) <= 0 || !isset($_GET['type']) || ($_GET['type'] != 'pos' && $_GET['type'] != 'neg'))
{
    header('location: index.php');
    exit();
}

$id = intval($_GET['id']);
$type = htmlspecialchars($_GET['type']);
$nb_pt_reput = calcul_nb_reput($_SESSION['id']);
if($type == 'neg')
    $nb_pt_reput *= -1;

mysql_query('UPDATE checks SET if_reput = 1, reput = '.$nb_pt_reput.' WHERE id = '.$id.' AND id_checkeur = '.$_SESSION['id'].' AND if_reput = 0');
header('location: index.php');
?>