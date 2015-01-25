<?php
include('include_haut.php');
include("page_haut.php"); ?>
<div id="last_check"><h1>Derniers checks</h1>
<?php $requete = mysql_query('SELECT utilisateurs.pseudo, anonymous.pseudo AS pseudo_anonymous, utilisateurs.id, checks.id AS id_check, avatar, uid, moment, if_reput,
UNIX_TIMESTAMP() - UNIX_TIMESTAMP(moment) as nb_seconds FROM checks
LEFT JOIN utilisateurs ON utilisateurs.id = checks.id_checke
LEFT JOIN anonymous ON anonymous.id_check = checks.id
WHERE id_checkeur = '.$_SESSION['id'].' ORDER BY moment DESC');
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
} else
    echo $donnees['pseudo_anonymous'].'<br />';
echo faire_date_lisible($donnees['nb_seconds'], $donnees['moment']); ?>
</div>
<?php } ?>
</div>
<?php include("page_bas.php"); ?>