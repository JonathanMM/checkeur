<?php
session_start();
require_once("config_mysql.php");
require_once("fonctions.php");
if(isset($_SESSION['co']) && $_SESSION['co'] === true)
{
    	header('location: index.php');
	exit();
} elseif(isset($_COOKIE['pseudo']) && isset($_COOKIE['mdp']))
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
	header('location: index.php');
	exit();
    }
}

if(isset($_POST['envoi']) && $_POST['envoi'] == 1)
{

    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mdp = htmlspecialchars($_POST['mdp']);
    $requete = mysql_query('SELECT id, code, mdp, uid FROM utilisateurs WHERE pseudo = "'.$pseudo.'" AND valide = 1');
    if($donnees = mysql_fetch_array($requete))
    {
	$hashage = hash('sha512', $mdp.$donnees['code']);
	if($hashage == $donnees['mdp'])
	{
		$_SESSION['co'] = true;
		$_SESSION['id'] = $donnees['id'];
		$_SESSION['pseudo'] = $pseudo;
		$_SESSION['uid'] = $donnees['uid'];
		if(isset($_POST['memoire']) && $_POST['memoire'] == 1)
		{
		    setcookie('pseudo', $pseudo, time() + 365*24*3600);
		    setcookie('mdp', $hashage, time() + 365*24*3600);
		}
		if(isset($_SESSION['aval_pseudo']) && isset($_SESSION['aval_code'])) //Code à valider
		{
		    //header('location: check.php?pseudo='.$_SESSION['aval_pseudo'].'&code='.$_SESSION['code']);
		    $requete = mysql_query('SELECT id_user, id_evenement FROM codes INNER JOIN utilisateurs ON utilisateurs.id = codes.id_user
WHERE pseudo = "'.$_SESSION['aval_pseudo'].'" AND codes.code = "'.$_SESSION['aval_code'].'"
AND date_debut <= (NOW() + INTERVAL 5 MINUTE) AND date_fin >= (NOW() - INTERVAL 5 MINUTE)');
		    if(!($requete === false) && $donnees = mysql_fetch_array($requete))
			mysql_query('INSERT INTO checks (id_checkeur, id_checke, moment, evenement) VALUES ('.$_SESSION['id'].', '.$donnees['id_user'].', NOW(), '.$donnees['id_evenement'].')') or die(mysql_error());
		    unset($_SESSION['aval_pseudo']);
		    unset($_SESSION['aval_code']);
		    exit();
		}
		header('location: index.php');
		exit();
	}
    } else {
	echo "<p>Erreur de pseudo ou compte non validé</p>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Checkeur</title>
<script type="text/javascript">
</script>
    <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body> 
<h1>Connexion</h1>
<form action="connexion.php" method="post">
<label name="pseudo">Pseudo : <br />
<input name="pseudo" /></label><br />
<label name="mdp">Mot de passe : <br />
<input name="mdp" type="password" /></label><br />
<label name="memoire"><input type="checkbox" name="memoire" value="1" class="checkbox" /> Mémoriser</label><br />
<input name="envoi" value="1" type="hidden" />
<input type="submit" value="Valider" />
</form>
<p><a href="inscription.php">S'inscrire</a></p>
    </body>
</html>
<?php mysql_close(); ?>