<?php
include('include_haut.php');
include("page_haut.php");
if(!isset($_GET['id']) || intval($_GET['id']) <= 0)
{
    header('Location: events.php');
    exit();
}
?>
<script type="text/javascript">
function afficher()
{
    if(document.getElementById('info').style.display == 'block')
	document.getElementById('info').style.display = 'none';
    else
	document.getElementById('info').style.display = 'block';
}
</script>
<?php
$requete = mysql_query('SELECT *, codes.date_debut AS date_debut, codes.date_fin AS date_fin FROM codes INNER JOIN evenements ON evenements.id = codes.id_evenement WHERE codes.id = '.intval($_GET['id']));
if(!($requete === false) && $donnees = mysql_fetch_array($requete))
{
    echo '<h1>'.$donnees['nom'].'</h1>';
    echo '<div class="qrcode">';
    if($donnees['code'] != NULL)
	$lien = 'http://checkeur.nocle.fr/check.php?pseudo='.$_SESSION['pseudo'].'&code='.$donnees['code'];
    else
	$lien = 'http://checkeur.nocle.fr/check.php?pseudo='.$_SESSION['pseudo'];
    require_once('qrcode.class.php');
    $qrcode = new QRcode($lien, 'M'); // error level : L, M, Q, H
    $qrcode->displayHTML();
echo '</div>';
if(isset($donnees['code']) && $donnees['code'] != NULL)
    echo 'Code : '.$donnees['code'].'<br />';
echo 'Du '.afficher_date($donnees['date_debut']).' au '.afficher_date($donnees['date_fin']).'.<br />
<a onclick="afficher();" style="text-decoration: underline;">Plus d\'info</a>
<div id="info" style="display: none;">URL : http://checkeur.nocle.fr/check.php?pseudo='.$_SESSION['pseudo'];
if($donnees['code'] != NULL)
    echo '&code='.$donnees['code'];
echo '<br />
Lien du QR Code : http://checkeur.nocle.fr/qrcode.php?pseudo='.$_SESSION['pseudo'];
if($donnees['code'] != NULL)
    echo '&code='.$donnees['code'];
echo '&hd=oui</div>';
}
?>
<?php include('page_bas.php'); ?>