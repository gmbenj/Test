<?php

include_once 'function.php';

ParcourirLesImagesDuReperoire()	;



if(!empty($_POST))
{
// on récupère ce qu'il y a dans post et on ajoute autant de fois le nom du picto ($rebuild_link_pictogramme) qu'il y a d'itération, dans un array qui s'appelle $liste_picto_complet[]
$array_post = $_POST;
$liste_picto_complet = array();
	foreach($array_post as $pictogramme => $nombre) 
	{
		$rebuild_link_pictogramme = $pictogramme.".jpg";
		
		for ($i=0; $i<$nombre; $i++)
		{
		$liste_picto_complet[]= $rebuild_link_pictogramme;
		}
	}


CreationGrille($liste_picto_complet);

}
else
{
	echo "rien";
}