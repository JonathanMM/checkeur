<?php
error_reporting(E_ERROR);
require_once('include_haut.php');
if($_SESSION['uid'] != 0)
{
    $xml = new DOMDocument();
    $xml->loadHTMLFile('http://forum.nolife-tv.com/member.php?u='.$_SESSION['uid']);
    $pseudo = $xml->getElementById('username_box')->getElementsByTagName('h1');
    $pseudo = $pseudo->item(0)->nodeValue;
    $infos = $xml->getElementById('collapseobj_stats_mini')->getElementsByTagName('div');
    $infos = $infos->item(0)->getElementsByTagName('table');
   // $infos = $infos->item(0)->getElementsByTagName('tbody');
    $infos = $infos->item(0)->getElementsByTagName('tr');
    $infos = $infos->item(0)->getElementsByTagName('td');
    $avatar = $infos->item(1)->getElementsByTagName('img');
    $avatar = $avatar->item(0)->getAttribute('src');
    $avatar = explode('_', $avatar);
    $avatar = explode('.', $avatar[1]);
    $avatar = intval($avatar[0]);
    $infos = $infos->item(0)->getElementsByTagName('dl');
    $infos = $infos->item(0);
    $dt = $infos->getElementsByTagName('dt');
    $dd = $infos->getElementsByTagName('dd');
    foreach($dt as $i => $def)
    {
	if($def->nodeValue == 'Date d\'inscription')
		$date_inscription = $dd->item($i)->nodeValue;
	elseif($def->nodeValue == 'Messages au total')
		$nb_message = $dd->item($i)->nodeValue;
    }
    if(strlen($nb_message) >= 6)
	$nb_message = (intval(substr($nb_message, 0, 2)) * 1000) + substr($nb_message, -3);
    else
	$nb_message = intval($nb_message);
    $explode_date = explode('/', trim($date_inscription));
    $date = date_create();
    date_date_set($date, $explode_date[2], $explode_date[1], $explode_date[0]);
    $date_inscription = date_format($date, 'Y-m-d');
    mysql_query('UPDATE utilisateurs SET nb_msg = "'.$nb_message.'", avatar = '.$avatar.', date_inscription = "'.$date_inscription.'" WHERE id = '.$_SESSION['id']);
}
header('location: params.php');
?>