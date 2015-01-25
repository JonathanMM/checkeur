<?php
include('include_haut.php');
include("page_haut.php"); ?>
<div id="last_checkage"><h1>Derniers qui vous ont checké</h1>
<?php $requete = mysql_query('SELECT pseudo, utilisateurs.id, avatar, uid, moment, if_reput, reput, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(moment) as nb_seconds FROM checks
INNER JOIN utilisateurs ON utilisateurs.id = checks.id_checkeur WHERE id_checke = '.$_SESSION['id'].' ORDER BY moment DESC');
while(!($requete === false) && $donnees = mysql_fetch_array($requete))
{ ?>
<div class="check_item">
<?php echo '<a href="details.php?id='.$donnees['id'].'">+</a>';
if($donnees['if_reput'] == 1)
    echo ' <span class="reput">'.$donnees['reput'].'</span>';

if($donnees['avatar'] != 0 && $donnees['uid'] != 0)
	    echo '<img src="http://forum.nolife-tv.com/customavatars/avatar'.$donnees['uid'].'_'.$donnees['avatar'].'.gif" alt="Avatar" />';
echo $donnees['pseudo'].'<br />';
echo faire_date_lisible($donnees['nb_seconds'], $donnees['moment']); ?>
</div>
<?php } ?>
</div>
<?php include("page_bas.php"); ?>