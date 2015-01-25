<?php
error_reporting(E_ERROR);
include('include_haut.php');
if(isset($_POST['envoi']) && $_POST['envoi'] == 1)
{
    if ($_FILES['photo']['error'] == 4) //On supprime la photo
	mysql_query('UPDATE utilisateurs SET photo = NULL WHERE id = '.$_SESSION['id']);
    elseif ($_FILES['photo']['error'] > 0)
	echo 'Erreur lors de l\'envoi de la photo.';
    elseif($_FILES['photo']['type'] != 'image/jpeg')
	echo 'Erreur de format du fichier';
    else
    {
	$nom = md5(uniqid(rand(), true));
	move_uploaded_file($_FILES['photo']['tmp_name'],'images/photos/'.$nom.'.jpg');
	mysql_query('UPDATE utilisateurs SET photo = "'.$nom.'" WHERE id = '.$_SESSION['id']);
    }
} elseif(isset($_POST['envoi']) && $_POST['envoi'] == 2) //On syncro l'uid
{
	$uid = intval($_POST['uid']);
    	$xml = new DOMDocument();
	$xml->loadHTMLFile('http://forum.nolife-tv.com/member.php?u='.$uid);
	$pseudo = $xml->getElementById('username_box')->getElementsByTagName('h1');
	$pseudo = $pseudo->item(0)->nodeValue;
	$pseudo = trim($pseudo);
	if($pseudo == $_SESSION['pseudo']) //C'est gagné \o/
	{
	    mysql_query('UPDATE utilisateurs SET uid = '.$uid.' WHERE id = '.$_SESSION['id']);
	    $_SESSION['uid'] = $uid;
	    header('location: resyncro.php');
	    exit();
	} else
	    echo "Erreur de UID";
}
include("page_haut.php");
?>
<h1>Paramètres</h1>
<?php
$requete = mysql_query('SELECT * FROM utilisateurs WHERE id = '.$_SESSION['id']);
$donnees = mysql_fetch_array($requete);
echo $donnees['pseudo'].'<br />';
if($donnees['avatar'] != 0 && $donnees['uid'] != 0)
    echo '<img src="http://forum.nolife-tv.com/customavatars/avatar'.$donnees['uid'].'_'.$donnees['avatar'].'.gif" alt="Avatar" /><br />';

if($_SESSION['uid'] == 0) //Pas de UID entré
{ ?>
<form method="post" action="params.php" enctype="multipart/form-data">
<p><label name="uid">UID : <br />
<input name="uid" /></label><br />
<input type="hidden" name="envoi" value="2" />
<input type="submit" name="Valider" />
</p></form>
<?php }

if($donnees['photo'] != NULL)
{
    echo 'Photo :<br /><img src="images/photos/'.$donnees['photo'].'.jpg" alt="Photo" /><br />';
}
?>
<form method="post" action="params.php" enctype="multipart/form-data">
<p><label name="photo">Envoyer une nouvelle photo (jpeg uniquement) :<br />
<input type="file" name="photo" /></label><br />
<input type="hidden" name="envoi" value="1" />
<input type="submit" name="Valider" />
</p></form>

<div class="check_liste_complete_lien">
<?php if($_SESSION['uid'] != 0) { ?>
    <a href="resyncro.php">Resyncroniser l'avatar</a>
<?php } ?>
</div>
<?php include("page_bas.php"); ?>