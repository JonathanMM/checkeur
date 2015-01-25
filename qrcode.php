<?php
    require_once('qrcode.class.php');
    if(isset($_GET['code']) && $_GET['code'] != NULL)
	$lien = 'http://checkeur.nocle.fr/check.php?pseudo='.htmlspecialchars($_GET['pseudo']).'&code='.htmlspecialchars($_GET['code']);
    else
	$lien = 'http://checkeur.nocle.fr/check.php?pseudo='.htmlspecialchars($_GET['pseudo']);
    $qrcode = new QRcode($lien, 'M'); // error level : L, M, Q, H
    if(isset($_GET['tab']))
	$qrcode->displayHTML();
    if(isset($_GET['hd']))
	$qrcode->displayPNG(1000);
    elseif(isset($_GET['taille']))
	$qrcode->displayPNG(intval($_GET['taille']));
    else
	$qrcode->displayPNG(200);
?>