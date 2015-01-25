<?php 
include('include_haut.php');
if(!isset($_GET['id']) || intval($_GET['id']) <= 0)
{
    header('location: index.php');
    exit();
}
$id = intval($_GET['id']);

$requete = mysql_query('SELECT *, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_checklieu) as nb_secondes FROM utilisateurs WHERE id = '.$id);
$donnees = mysql_fetch_array($requete);
include("page_haut.php");
echo '<h2>'.$donnees['pseudo'].'</h2><p class="detail">';
if($donnees['avatar'] != 0 && $donnees['uid'] != 0)
	    echo '<img src="http://forum.nolife-tv.com/customavatars/avatar'.$donnees['uid'].'_'.$donnees['avatar'].'.gif" alt="Avatar" /><br />';
if($donnees['photo'] != NULL)
{
    echo 'Photo :<br /><img src="images/photos/'.$donnees['photo'].'.jpg" alt="Photo" /><br />';
}

afficher_nb_reput($id);
?>
Dernier checklieu :<br />
<?php if($donnees['lieu'] != NULL)
    echo $donnees['lieu'].'<br />'.faire_date_lisible($donnees['nb_secondes'], $donnees['date_checklieu']);
else
    echo 'Aucune information';
?></p>
<?php include('page_bas.php'); ?>