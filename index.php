<?php
include('include_haut.php');
include("page_haut.php"); ?>
<nav>
<a href="checker.php">Check</a> | <a href="checker_lieu.php">Checklieu</a>
</nav>

<div id="last_check"><h1>Derniers checks</h1>
<?php $requete = mysql_query('SELECT utilisateurs.pseudo, anonymous.pseudo AS pseudo_anonymous, utilisateurs.id, checks.id AS id_check, avatar, uid, moment, if_reput,
UNIX_TIMESTAMP() - UNIX_TIMESTAMP(moment) as nb_seconds FROM checks
LEFT JOIN utilisateurs ON utilisateurs.id = checks.id_checke
LEFT JOIN anonymous ON anonymous.id_check = checks.id
WHERE id_checkeur = '.$_SESSION['id'].'
ORDER BY moment DESC LIMIT 0,3') or die(mysql_error());
while(!($requete === false) && $donnees = mysql_fetch_array($requete))
{ ?>
<div class="check_item">
<?php
if(isset($donnees['id']) && $donnees['id'] != NULL) //Un inscrit
{
    echo '<a href="details.php?id='.$donnees['id'].'">+</a>';
    if($donnees['if_reput'] == 0 && $_SESSION['uid'] != 0)
    {
    echo '<a href="reput.php?type=neg&amp;id='.$donnees['id_check'].'" style="color: red">⊖</a>
    <a href="reput.php?type=pos&amp;id='.$donnees['id_check'].'" style="color: green">⊕</a>';
    }
    if($donnees['avatar'] != 0 && $donnees['uid'] != 0)
		echo '<img src="http://forum.nolife-tv.com/customavatars/avatar'.$donnees['uid'].'_'.$donnees['avatar'].'.gif" alt="Avatar" />';
    echo $donnees['pseudo'].'<br />';
} else //Un anonymous, on doit récupérer son pseudo
     echo $donnees['pseudo_anonymous'].'<br />';
echo faire_date_lisible($donnees['nb_seconds'], $donnees['moment']); ?>
</div>
<?php } ?>
<div class="check_liste_complete_lien"><a href="liste_check.php">Liste complète</a></div>
</div>

<div id="last_checkage"><h1>Derniers qui vous ont checké</h1>
<?php $requete = mysql_query('SELECT pseudo, utilisateurs.id, checks.id AS id_check, if_reput, reput, avatar, uid, moment, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(moment) as nb_seconds
FROM checks INNER JOIN utilisateurs ON utilisateurs.id = checks.id_checkeur
WHERE id_checke = '.$_SESSION['id'].' ORDER BY moment DESC LIMIT 0,3') or die(mysql_error());
while(!($requete === false) && $donnees = mysql_fetch_array($requete))
{ ?>
<div class="check_item">
<?php echo '<a href="details.php?id='.$donnees['id'].'">+</a>';
if($donnees['if_reput'] == 1)
    echo ' <span class="reput">'.$donnees['reput'].'</span>';

if($donnees['avatar'] != 0 && $donnees['uid'] != 0)
	    echo '<img src="http://forum.nolife-tv.com/customavatars/avatar'.$donnees['uid'].'_'.$donnees['avatar'].'.gif" alt="Avatar" />';
echo $donnees['pseudo'].'<br />';
echo faire_date_lisible($donnees['nb_seconds'], $donnees['moment']);
?>
</div>
<?php } ?>
<div class="check_liste_complete_lien"><a href="liste_checkage.php">Liste complète</a></div>
</div>

<nav><a href="events.php">Événement</a> | <a href="rechercher.php">Recherche</a> | <a href="params.php">Paramètres</a></nav>
<?php include("page_bas.php"); ?>