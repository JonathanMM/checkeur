<?php
include('include_haut.php');
if(isset($_POST['envoi']) && $_POST['envoi'] == 2)
{
    $id_evenement = intval($_POST['id_event']);
    $code = htmlspecialchars($_POST['code']);
    if(isset($_POST['tout_moment']) && $_POST['tout_moment'] == 1)
    {
	$requete = mysql_query('SELECT date_debut, date_fin FROM evenements WHERE id = '.$id_evenement);
	$donnees = mysql_fetch_array($requete);
	$date_debut = $donnees['date_debut'];
	$date_fin = $donnees['date_fin'];
    } else {
	$date_debut = date_valide(htmlspecialchars($_POST['date_debut']));
	$date_fin = date_valide(htmlspecialchars($_POST['date_fin']));
	if($date_debut === false || $date_fin === false)
	{
	    echo 'Erreur';
	    exit();
	}
    }

    if($id_evenement > 0)
    {
	if(strlen($code) > 0)
	{
	    mysql_query('INSERT INTO codes (id_user, code, id_evenement, date_debut, date_fin) VALUES ('.$_SESSION['id'].', "'.$code.'", '.$id_evenement.', "'.$date_debut.'", "'.$date_fin.'")');
	    header('location: events.php');
	    exit();
	} elseif(isset($_POST['aucun_code']) && $_POST['aucun_code'] == 1)
	{
	    mysql_query('INSERT INTO codes (id_user, code, id_evenement, date_debut, date_fin) VALUES ('.$_SESSION['id'].', NULL, '.$id_evenement.', "'.$date_debut.'", "'.$date_fin.'")');
	    header('location: events.php');
	    exit();
	} else
	{
	    echo "Aucun code entré.";
	    exit();
	}
    } else {
	echo 'Erreur';
	exit();
    }
} elseif(isset($_POST['envoi']) && $_POST['envoi'] == 1)
{
    $id_evenement = intval($_POST['id_event']);
    if($id_evenement == 0) //Nouvel event
    {
	$nom = htmlspecialchars($_POST['nom']);
	$lieu = htmlspecialchars($_POST['lieu']);
	$date_debut = date_valide(htmlspecialchars($_POST['date_debut']));
	$date_fin = date_valide(htmlspecialchars($_POST['date_fin']));
	if(strlen($nom) > 0 && strlen($lieu) > 0 && !($date_debut === false) && !($date_fin === false))
	{
	    mysql_query('INSERT INTO evenements (nom, date_debut, date_fin, lieu) VALUES ("'.$nom.'", "'.$date_debut.'", "'.$date_fin.'", "'.$lieu.'")');
	    $id_evenement = mysql_insert_id();
	} else
	{
	    echo 'Erreur';
	    exit();
	}
    }
    $requete = mysql_query('SELECT nom, date_debut, date_fin FROM evenements WHERE id = '.$id_evenement);
    $donnees = mysql_fetch_array($requete);
    include("page_haut.php");
    ?>
    <form action="ajouter_code.php" method="post">
    Événement : <?php echo $donnees['nom']; ?><br />
    <label name="tout_moment"><input type="checkbox" name="tout_moment" value="1" /> Tout l'événement</label><br />
    ou <br />
    <label name="date_debut">Du (format AAAA-MM-JJ HH:MM:SS)<br /><input name="date_debut" type="datetime" /></label><br />
    <label name="date_fin">Au (format AAAA-MM-JJ HH:MM:SS)<br /><input name="date_fin" type="datetime" /></label><br />
    <label name="code">Code : <input name="code" /></label><br />
    <label name="aucun_code"><input type="checkbox" name="aucun_code" value="1" /> Aucun code</label><br />
    <input name="id_event" value="<?php echo $id_evenement; ?>" type="hidden" />
    <input name="envoi" value="2" type="hidden" />
    <input type="submit" value="Valider" />
    <?php
} else {
include("page_haut.php");
?>
<h1>Ajouter un code</h1>
<form action="ajouter_code.php" method="post">
Evenement :
<select name="id_event">
<option value="0">Nouvel événement</option>
<?php $requete = mysql_query('SELECT * FROM evenements WHERE date_fin >= NOW()') or die(mysql_error());
while(!($requete === false) && $donnees = mysql_fetch_array($requete))
{
    echo '<option value="'.$donnees['id'].'">'.$donnees['nom'].'</option>';
}
?>
</select><br />
ou<br />
<label name="nom">Nom :<br />
<input name="nom" /></label><br />
<label name="date_debut">Début (format AAAA-MM-JJ HH:MM:SS) :<br />
<input name="date_debut" type="datetime" /></label><br />
<label name="date_fin">Fin (format AAAA-MM-JJ HH:MM:SS) :<br />
<input name="date_fin" type="datetime" /></label><br />
<label name="lieu">Lieu :<br />
<input name="lieu" /></label><br />
<input name="envoi" value="1" type="hidden" />
<input type="submit" value="Valider" />
</form>
<?php } include('page_bas.php'); ?>