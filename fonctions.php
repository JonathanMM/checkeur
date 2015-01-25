<?php
function generer_code()
{
    $code = '';
    $chaine="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz0123456789";
    for($i = 0; $i < 8; $i++)
	$code .= $chaine[rand (0, strlen($chaine) - 1)];
    return $code;
}

function date_valide($date)
{
    $coupe = explode(' ', $date);
    if(!isset($coupe[1]))
	return false;
    
    $coupe_date = explode('-', $coupe[0]);
    if(!isset($coupe_date[1])) //Format : JJ/MM/AAAA ?
    {
	$coupe_date = explode('/', $coupe[0]);
	if(isset($coupe_date[1])) //Bingo
	{
	    $coupe_date = array(0 => $coupe_date[2], 1 => $coupe_date[1], 2 => $coupe_date[2]);
	    $date = intval($coupe_date[2]).'-'.intval($coupe_date[1]).'-'.intval($coupe_date[0]).' '.$coupe[1];
	} else
	    return false;
    }

    if(intval($coupe_date[1]) >= 1 && intval($coupe_date[1]) <= 12 && intval($coupe_date[2]) >= 1 && intval($coupe_date[2]) <= 31)
	return $date;
    else
	return false;
}

function faire_date_lisible($nb_secondes, $date)
{
    if($nb_secondes < 60)
	return 'Il y a '.$nb_secondes.'s.';
    elseif($nb_secondes < 3600)
	return 'Il y a '.floor($nb_secondes / 60).'min.';
    elseif($nb_secondes < 86400)
	return 'Il y a '.floor($nb_secondes / 3600).'h.';
    else
	return 'Le '.afficher_date($date).'.';
}

function afficher_date($date)
{
    $coupe = explode(' ', $date);
    $coupe2 = explode('-', $coupe[0]);
    return $coupe2[2].'/'.$coupe2[1].'/'.$coupe2[0].', '.$coupe[1];
}

function calcul_nb_reput($id)
{
    $don = maj_nb_reput($id);
    $requete = mysql_query('SELECT nb_msg, YEAR(NOW()) - YEAR(date_inscription) AS nb_an FROM utilisateurs WHERE id = '.$id);
    $donnees = mysql_fetch_array($requete);
    $return = 1 + floor(abs($don) / 100) + $donnees['nb_an'] + floor($donnees['nb_msg'] / 1000);
    if($donnees['nb_msg'] < 50 || $donnees['uid'] == 0)
	return 0;
    else
	return $return;
}

function maj_nb_reput($id)
{
    $requete = mysql_query('SELECT SUM(reput) as total FROM checks WHERE id_checke = '.$id);
    $donnees = mysql_fetch_array($requete);
    mysql_query('UPDATE utilisateurs SET pts_reput = '.$donnees['total'].' WHERE id = '.$id);
    return $donnees['total'];
}

function afficher_nb_reput($id)
{
    $nb_pts_reput = maj_nb_reput($id);
    if($nb_pts_reput < 0)
    {
	if($nb_pts_reput <= -150)
	    echo '<img src="images/rouge.png" alt="-" />';
	if($nb_pts_reput <= -100)
	    echo '<img src="images/rouge.png" alt="-" />';
	if($nb_pts_reput <= -50)
	    echo '<img src="images/rouge.png" alt="-" />';
	if($nb_pts_reput <= -10)
	    echo '<img src="images/rouge.png" alt="-" />';
	if($nb_pts_reput <= -1)
	    echo '<img src="images/rouge.png" alt="-" />';
    } elseif($nb_pts_reput == 0)
	echo '<img src="images/jaune.png" alt="±" />';
    else
    {
	if($nb_pts_reput >= 1)
	    echo '<img src="images/vert.png" alt="+" />';
	if($nb_pts_reput >= 10)
	    echo '<img src="images/vert.png" alt="+" />';
	if($nb_pts_reput >= 50)
	    echo '<img src="images/vert.png" alt="+" />';
	if($nb_pts_reput >= 100)
	    echo '<img src="images/vert.png" alt="+" />';
	if($nb_pts_reput >= 250)
	    echo '<img src="images/vert.png" alt="+" />';
	if($nb_pts_reput >= 500)
	    echo '<img src="images/plus_vert.png" alt="+" />';
	if($nb_pts_reput >= 1000)
	    echo '<img src="images/plus_vert.png" alt="+" />';
	if($nb_pts_reput >= 2500)
	    echo '<img src="images/plus_vert.png" alt="+" />';
	if($nb_pts_reput >= 5000)
	    echo '<img src="images/plus_vert.png" alt="+" />';
	if($nb_pts_reput >= 10000)
	    echo '<img src="images/plus_vert.png" alt="+" />';
	if($nb_pts_reput >= 20000)
	    echo '<img src="images/plus_vert.png" alt="+" />';
    }
    echo '<br />';
}
?>