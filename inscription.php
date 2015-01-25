<?php
error_reporting(E_ERROR);
session_start();
require_once("config_mysql.php");
require_once("fonctions.php");
if(isset($_SESSION['co']) && $_SESSION['co'] === true)
{
    	header('location: index.php');
	exit();
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
<h1>Inscription</h1>
<?php
if(isset($_GET['valide']) && $_GET['valide'] == 1 && isset($_SESSION['uid']) && isset($_SESSION['pseudo']))
{
    $code = generer_code();
    if($_SESSION['uid'] == 42781)
    {
	$plus_un = ', photo';
	$plus_deux = ', 1';
    }
    mysql_query('INSERT INTO utilisateurs (pseudo, code, valide, uid, nb_msg, date_inscription, avatar'.$plus_un.')
VALUES ("'.$_SESSION['pseudo'].'", "'.$code.'", 0, "'.$_SESSION['uid'].'", "'.$_SESSION['nb_message'].'", "'.$_SESSION['date_inscription'].'", "'.$_SESSION['avatar'].'"'.$plus_deux.')');
    $id = mysql_insert_id();
    mysql_query('UPDATE checks SET id_checke = '.$id.' WHERE id IN (SELECT id_check FROM anonymous WHERE pseudo = "'.$_SESSION['pseudo'].'")') or die(mysql_error());
    mysql_query('DELETE FROM anonymous WHERE pseudo = "'.$_SESSION['pseudo'].'"') or die(mysql_error());
    $fichier = fopen('mp.txt', 'a+');
    fwrite($fichier, 'Pseudo : '.$_SESSION['pseudo']."\n");
    fwrite($fichier, 'Lien : http://forum.nolife-tv.com/private.php?do=newpm&u='.$_SESSION['uid']."\n");
    fwrite($fichier, "Bonjour,\nCeci est un MP semi automatique suite à votre inscription sur le site Checkeur. Pour finaliser votre inscription, veuillez cliquer sur le lien suivant
http://checkeur.nocle.fr/valider_compte.php?u=".$_SESSION['uid']."&code=".$code."\nMerci d'utiliser ce site et bonne journée :)\n");
    fwrite($fichier, "***************************************************\n");
    fclose($fichier);
    echo "Votre inscription a été prise en compte, vous allez recevoir prochaînement un MP sur le forum de Nolife pour vous permettre de finaliser votre inscription ;)";
} elseif(isset($_POST['envoi']) && $_POST['envoi'] == 1)
{
    $uid = intval($_POST['uid']);
    $pseudo_post = htmlspecialchars($_POST['pseudo']);
    //On va quand même voir si le dit pseudo ne s'est pas déjà inscrit…
    $requete = mysql_query('SELECT id FROM utilisateurs WHERE pseudo = "'.$pseudo_post.'"');
    /*if(!($requete === false) && $donnees = mysql_fetch_array($requete) && isset($donnees['id']) && $donnees != NULL)
    {*/
	$xml = new DOMDocument();
	$xml->loadHTMLFile('http://forum.nolife-tv.com/member.php?u='.$uid);
	$pseudo = $xml->getElementById('username_box')->getElementsByTagName('h1');
	$pseudo = $pseudo->item(0)->nodeValue;
	$infos = $xml->getElementById('collapseobj_stats_mini')->getElementsByTagName('div');
	$infos = $infos->item(0)->getElementsByTagName('table');
    // $infos = $infos->item(0)->getElementsByTagName('tbody');
	$infos = $infos->item(0)->getElementsByTagName('tr');
	$infos = $infos->item(0)->getElementsByTagName('td');
	if($infos->length >= 2)
	{
	    $avatar = $infos->item(1)->getElementsByTagName('img');
	    $avatar = $avatar->item(0)->getAttribute('src');
	    $avatar = explode('_', $avatar);
	    $avatar = explode('.', $avatar[1]);
	    $avatar = intval($avatar[0]);
	} else
	    $avatar = 0;
	$infos = $infos->item(0)->getElementsByTagName('dl');
	$infos = $infos->item(0);
	$dt = $infos->getElementsByTagName('dt');
	$dd = $infos->getElementsByTagName('dd');
	foreach($dt as $i => $def)
	{
	    if($def->nodeValue == 'Date d\'inscription')
		    $date_inscription = $dd->item($i)->nodeValue;
	    elseif($def->nodeValue == 'Messages au total')
		    $nb_message = $dd->item($i)->nodeValue;
	}
	if(strlen($nb_message) >= 6)
	    $nb_message = (intval(substr($nb_message, 0, 2)) * 1000) + substr($nb_message, -3);
	else
	    $nb_message = intval($nb_message);
	$explode_date = explode('/', trim($date_inscription));
	$date = date_create();
	date_date_set($date, $explode_date[2], $explode_date[1], $explode_date[0]);
	$date_inscription = date_format($date, 'Y-m-d');
	$pseudo = trim($pseudo);
	if($pseudo != $pseudo_post)
	{
	    echo 'Les pseudos en correspondent pas entre ce que vous avez indiqué et l\'uid correspondant';
	    exit();
	}
?>
<p>UID : <?php echo $uid; ?><br />
Pseudo : <?php echo ($uid == 42781) ? 'Compil\' <img src="http://forum.nolife-tv.com/images/smilies/slimenormal.gif" alt=":normal:" />' : $pseudo; ?><br />
Nombre de message : <?php echo $nb_message; ?><br />
Date d'inscription : <?php echo $date_inscription; ?></p>
<a style="text-decoration: underline;" href="inscription.php?valide=1">Continuer</a>
<?php
	$_SESSION['uid'] = $uid;
	$_SESSION['pseudo'] = $pseudo;
	$_SESSION['nb_message'] = $nb_message;
	$_SESSION['date_inscription'] = $date_inscription;
	$_SESSION['avatar'] = $avatar;
    /*} else { //Déjà inscrit
echo $donnees['id'];
	echo 'Cette personne est déjà inscrite. En cas de problème, envoyer un MP à freeboite95.';
	exit();
    }*/
} else { ?>
<form action="inscription.php" method="post">
<label name="uid">UID : <br />
<input name="uid" /></label><br />
<label name="pseudo">Pseudo : <br />
<input name="pseudo" /></label><br />
<input name="envoi" value="1" type="hidden" />
<input type="submit" value="Valider" />
</form>
<?php } ?>    </body>
</html>
<?php mysql_close(); ?>