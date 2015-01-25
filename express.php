<?php
error_reporting(E_ERROR);
session_start();
require_once("config_mysql.php");
require_once("fonctions.php");
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
<h1>Inscription Express</h1>
<?php
if(isset($_POST['envoi']) && $_POST['envoi'] == 1)
{
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $code = htmlspecialchars($_POST['code']);
    $mdp = htmlspecialchars($_POST['mdp']);
    $remdp = htmlspecialchars($_POST['mdp_re']);
    if($mdp != $remdp)
    {
	echo "<p>Les mots de passes ne correspondent pas</p>";
	exit();
    } elseif($code != 'JE12')
    {
	echo "<p>Le code de validation est incorrect !</p>";
	exit();
    }
	$code_mdp = generer_code();
	$hashage = hash('sha512', $mdp.$code_mdp);
	mysql_query('INSERT INTO utilisateurs (pseudo, mdp, code, valide, uid, nb_msg, date_inscription, avatar)
	VALUES ("'.$_SESSION['pseudo'].'", "'.$hashage.'", "'.$code_mdp.'", 1, 0, 0, "0000-00-00", 0)');
	echo "<p>Merci, le compte est maintenant validé, vous pouvez dorénavant vous connecter<br /><a href='connexion.php'>Se connecter</a></p>";
} else { ?>
<form action="express.php" method="post">
<label name="pseudo">Pseudo : <br />
<input name="pseudo" /></label><br />
<label name="mdp">Mot de passe : <br />
<input name="mdp" type="password" /></label><br />
<label name="mdp_re">Encore une fois : <br />
<input name="mdp_re" type="password" /></label><br />
<label name="code">Code de validation : <br />
<input name="code" /></label><br />
<input name="envoi" value="1" type="hidden" />
<input type="submit" value="Valider" />
</form>
<?php } ?>
</body>
</html>
<?php mysql_close(); ?>