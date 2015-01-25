<?php
include('include_haut.php');
if(isset($_POST['envoi']) && $_POST['envoi'] == 1)
{
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $code = htmlspecialchars($_POST['code']);
    $moment = date_valide(htmlspecialchars($_POST['moment']));
    if(!($moment === false) && strlen($pseudo) > 0)
    {
	//On commence par voir si le monsieur est en BDD
	$requete = mysql_query('SELECT id FROM utilisateurs WHERE pseudo = "'.$pseudo.'"');
	if(!($requete === false) && $donnees2 = mysql_fetch_array($requete)) //Oui
	{
	    $id_personne = $donnees2['id'];
		if(strlen($code) > 0)
		    $requete = mysql_query('SELECT id_evenement FROM codes WHERE id_user = "'.$id_personne.'" AND codes.code = "'.$code.'"
					    AND date_debut <= ("'.$moment.'" + INTERVAL 5 MINUTE) AND date_fin >= ("'.$moment.'" - INTERVAL 5 MINUTE)');
		else
		    $requete = mysql_query('SELECT id_evenement FROM codes WHERE id_user = "'.$id_personne.'"
					    AND date_debut <= ("'.$moment.'" + INTERVAL 5 MINUTE) AND date_fin >= ("'.$moment.'" - INTERVAL 5 MINUTE)');

		if(!($requete === false) && $donnees = mysql_fetch_array($requete))
		{
		    mysql_query('INSERT INTO checks (id_checkeur, id_checke, moment, evenement) VALUES ('.$_SESSION['id'].', '.$id_personne.', "'.$moment.'", '.$donnees['id_evenement'].')') or die(mysql_error());
		    header('location: index.php');
		    exit();
		} else {
		    echo "Erreur";
		    exit();
		}
	} else { //Non, on utilise la procedure anonymous
	    mysql_query('INSERT INTO checks (id_checkeur, id_checke, moment, evenement) VALUES ('.$_SESSION['id'].', 0, "'.$moment.'", 0)') or die(mysql_error());
	    $id_check = mysql_insert_id();
	    mysql_query('INSERT INTO anonymous (id_check, pseudo) VALUES ('.$id_check.', "'.$pseudo.'")');
	    header('location: index.php');
	    exit();
	}
    } else {
	echo "Erreur";
	exit();
    }
}
include("page_haut.php");
?>
<h1>Checker</h1>
<form action="checker.php" method="post">
<label name="pseudo">Pseudo : <br />
<input name="pseudo" /></label><br />
<label name="code">Code : <br />
<input name="code" /></label><br />
<label name="moment">Quand ? <a onclick="mettre_maintenant();" style="text-decoration: underline;">Maintenant</a><br />
Format : AAAA-MM-JJ HH:MM:SS<br />
<input name="moment" id="moment" /></label><br />
<input name="envoi" value="1" type="hidden" />
<input type="submit" value="Valider" />
</form>
<?php include('page_bas.php'); ?>