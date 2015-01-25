<?php require_once("config_mysql.php");
require_once("fonctions.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Checker</title>
<script type="text/javascript">
</script>
    <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
<h1>Inscription</h1>
<?php
if(isset($_POST['envoi']) && $_POST['envoi'] == 1)
{
    $uid = intval($_POST['uid']);
    $code = htmlspecialchars($_POST['code']);
    $mdp = htmlspecialchars($_POST['mdp']);
    $remdp = htmlspecialchars($_POST['mdp_re']);
    if($mdp != $remdp)
    {
	echo "<p>Les mots de passes ne correspondent pas</p>";
	exit();
    }
    $requete = mysql_query("SELECT code FROM utilisateurs WHERE uid = ".$uid." AND valide = 0");
    if($donnees = mysql_fetch_array($requete))
    {
	if($donnees['code'] != $code)
	{
		echo "<p>Les codes ne correspondent pas</p>";
		exit();
	}
	$hashage = hash('sha512', $mdp.$code);
	mysql_query('UPDATE utilisateurs SET valide = 1, mdp = "'.$hashage.'" WHERE uid = '.$uid);
	echo "<p>Merci, le compte est maintenant validé, vous pouvez dorénavant vous connecter<br /><a href='connexion.php'>Se connecter</a></p>";
    } else
    {
	echo "<p>L'uid n'est pas inscrit ou le compte est déjà validé</p>";
	exit();
    }
} elseif(isset($_GET['u']) && isset($_GET['code']))
{ ?>
<form action="valider_compte.php" method="post">
<label name="uid">UID : <br />
<input name="uid" value="<?php echo intval($_GET['u']); ?>" /></label><br />
<label name="code">Code : <br />
<input name="code" value="<?php echo $_GET['code']; ?>" /></label><br />
<label name="mdp">Mot de passe : <br />
<input name="mdp" type="password" /></label><br />
<label name="mdp_re">Encore une fois : <br />
<input name="mdp_re" type="password" /></label><br />
<input name="envoi" value="1" type="hidden" />
<input type="submit" value="Valider" />
</form>
<?php } else
{
    echo "<p>Erreur</p>";
} ?>
    </body>
</html>
<?php mysql_close(); ?>