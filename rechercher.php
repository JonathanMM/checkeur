<?php
include('include_haut.php');
if(isset($_POST['envoi']) && $_POST['envoi'] == 1)
{
    $pseudo = htmlspecialchars($_POST['pseudo']);
    if(strlen($pseudo) == 0)
    {
	header('location: index.php');
	exit();
    }

    $requete = mysql_query('SELECT id FROM utilisateurs WHERE pseudo = "'.$pseudo.'"');
    if(!($requete === false) && $donnees = mysql_fetch_array($requete))
    {
	header('location: details.php?id='.$donnees['id']);
	exit();
    } else {
	echo "Pas de résultat :(";
	exit();
    }
}
include("page_haut.php");
?>
<h1>Recherche</h1>
<form action="rechercher.php" method="post">
<label name="pseudo">Pseudo : <br />
<input name="pseudo" /></label><br />
<input name="envoi" value="1" type="hidden" />
<input type="submit" value="Valider" />
</form>
<?php include('page_bas.php'); ?>