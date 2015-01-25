<?php
include('include_haut.php');
if(!isset($_GET['pseudo']))
{
    header('location: index.php');
    exit();
}

$pseudo = htmlspecialchars($_GET['pseudo']);
if(isset($_GET['code']))
    $code = htmlspecialchars($_GET['code']);
else
    $code = NULL;

if(!isset($_SESSION['co']) || $_SESSION['co'] === false)
{
    if(isset($_COOKIE['pseudo']) && isset($_COOKIE['mdp']))
    {
	$pseudo = htmlspecialchars($_COOKIE['pseudo']);
	$mdp = htmlspecialchars($_COOKIE['mdp']);
	$requete = mysql_query('SELECT id, pseudo, uid FROM utilisateurs WHERE pseudo = "'.$pseudo.'" AND mdp = "'.$mdp.'" AND valide = 1');
	if($donnees = mysql_fetch_array($requete))
	{
	    $_SESSION['co'] = true;
	    $_SESSION['id'] = $donnees['id'];
	    $_SESSION['pseudo'] = $pseudo;
	    $_SESSION['uid'] = $donnees['uid'];
	}
    } else //direction la connexion
    {
	$_SESSION['aval_pseudo'] = $pseudo;
	$_SESSION['aval_code'] = $code;
	header('location: connexion.php');
	exit();
    }
}
    if($code != NULL)
	$requete = mysql_query('SELECT id_user, id_evenement FROM codes INNER JOIN utilisateurs ON utilisateurs.id = codes.id_user WHERE pseudo = "'.$pseudo.'" AND codes.code = "'.$code.'"
AND date_debut <= (NOW() + INTERVAL 5 MINUTE) AND date_fin >= (NOW() - INTERVAL 5 MINUTE)');
    else
	$requete = mysql_query('SELECT id_user, id_evenement FROM codes INNER JOIN utilisateurs ON utilisateurs.id = codes.id_user WHERE pseudo = "'.$pseudo.'"
AND date_debut <= (NOW() + INTERVAL 5 MINUTE) AND date_fin >= (NOW() - INTERVAL 5 MINUTE)');
    if(!($requete === false) && $donnees = mysql_fetch_array($requete))
    {
	mysql_query('INSERT INTO checks (id_checkeur, id_checke, moment, evenement) VALUES ('.$_SESSION['id'].', '.$donnees['id_user'].', NOW(), '.$donnees['id_evenement'].')') or die(mysql_error());
	echo 'OK';
	exit();
    } else {
	echo "Erreur";
	exit();
    }
?>