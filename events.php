<?php
include('include_haut.php');
include("page_haut.php"); ?>
<h1>Evenements</h1>
<div class="check_liste_complete_lien"><a href="ajouter_code.php">Ajouter un code</a></div>
<div id="last_events">
<?php $requete = mysql_query('SELECT *, codes.id AS id_code FROM codes INNER JOIN evenements ON evenements.id = codes.id_evenement WHERE codes.id_user = '.$_SESSION['id']);
while(!($requete === false) && $donnees = mysql_fetch_array($requete))
{
echo '<div class="event_item">';
echo $donnees['nom'].'<br />';
echo 'Du '.afficher_date($donnees['date_debut']).' au '.afficher_date($donnees['date_fin']).'.';
echo '<a style="text-decoration: underline; float: right;" href="afficher_qrcode.php?id='.$donnees['id_code'].'">Voir le QR Code associé</a>';
if(isset($donnees['code']) && $donnees['code'] != NULL)
    echo '<div class="code_event">Code : '.$donnees['code'].'</div>';
echo '</div>';
} ?>
</div>
<?php include("page_bas.php"); ?>