<?php
include('include_haut.php');
if(isset($_POST['envoi']) && $_POST['envoi'] == 1)
{
    $lieu = htmlspecialchars($_POST['lieu']);
    if(strlen($lieu) > 0)
	mysql_query('UPDATE utilisateurs SET lieu = "'.$lieu.'", date_checklieu = NOW() WHERE id = '.$_SESSION['id']);
    header('location: index.php');
    exit();
}
include("page_haut.php");
?>
<h1>Checker le lieu</h1>
<form action="checker_lieu.php" method="post">
<label name="lieu">Où êtes-vous ?<br />
<input name="lieu" /></label><br />
<input name="envoi" value="1" type="hidden" />
<input type="submit" value="Valider" />
</form>
<?php include('page_bas.php'); ?>