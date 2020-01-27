<?php

function Recadrage_Image($nombrut,$repertoireDestination,$extensionFichier,$nom)
{


$source = imagecreatefromjpeg($repertoireDestination.$nombrut.".jpg");

$wo = imagesx($source); // Largeur Origine
$ho = imagesy($source); // Hauteur Origine
$wc = 300; // Largeur Cible
$hc = 300; // Hauteur Cible
$ro = $wo/$ho; // Rapport Origine 
$rc = $wc/$hc; // Rapport Cible


echo "$wo & $ho & $wc & $hc & $ro & $rc";

if ($ro>$rc) // si Largeur > Hauteur
{

	$coeff_resize = $wo/$wc;//calcul du coefficient de redimensionnement
	echo " Largeur de l'image d'origine proportionnellement supérieur à la largeur de l'image de destination et le coeff est de $coeff_resize";
	$wd = floor($wo/$coeff_resize); //nouvelle largeur de destination
	$hd = floor($ho/$coeff_resize); // nouvelle hauteur de destination
	echo " $wo devient $wd et $ho devient $hd";


	
}
else // si Hauteur > Largeur
{
	$coeff_resize = $ho/$hc;//calcul du coefficient de redimensionnement
	echo " Largeur de l'image d'origine proportionnellement supérieur à la largeur de l'image de destination et le coeff est de $coeff_resize";
	$wd = floor($wo/$coeff_resize); //nouvelle largeur de destination
	$hd = floor($ho/$coeff_resize); // nouvelle hauteur de destination
	echo " $wo devient $wd et $ho devient $hd";
}


$picto = imagecreatetruecolor($wc, $hc);
$blanc = imagecolorallocate ($picto, 255, 255, 255);
imagefill($picto, 0, 0, $blanc);
// On crée la miniature
$deltaw = floor(($wc-$wd)/2); // ecart largeur
$deltah = floor(($hc-$hd)/2); // ecart hauteur
imagecopyresampled($picto, $source, $deltaw, $deltah, 0, 0, $wd, $hd, $wo, $ho);
echo " ecart largeur = $deltaw et ecart hauteur = $deltah";
$noir = imagecolorallocate($picto, 0, 0, 0);
imagerectangle($picto , 1 , 1 , 299 , 299 , $noir);

// On enregistre la miniature sous le nom "mini_couchersoleil.jpg"
imagejpeg($picto, $repertoireDestination.$nombrut.".jpg");
return;

}

function Convert_Png($nomDestination,$repertoireDestination,$nombrut)
{
$repdest = $repertoireDestination.$nombrut.".jpg";
echo "<br/> ?????$repdest <br/>";
$imagepng = imagecreatefrompng($repertoireDestination.$nomDestination);
imagejpeg($imagepng, $repdest, 75);
imagedestroy($imagepng);
}

function Convert_jpg($nomDestination,$repertoireDestination,$nombrut)
{
$repdest = $repertoireDestination.$nombrut.".jpg";
echo "<br/> !! ! !! $repdest <br/>";
$imagejpg = imagecreatefromjpeg($repertoireDestination.$nomDestination);

imagejpeg($imagejpg, $repdest, 100);
imagedestroy($imagejpg);
}


function ParcourirLesImagesDuReperoire()
{  
$images=glob('image/*.jpg', GLOB_BRACE);
echo '<form action="" method="post">';
foreach($images as $picto)
{
	$nom_img_ext = strrchr($picto,'/'); //récupère le nom de l'image avec son extension mais sans "image/"
	$nom_img = substr($nom_img_ext, 1, -4); //supprime l'extension du nom de l'image
	$dossier_nom_img = substr($picto, 0, -4); //supprime l'extension du nom du chemin + image
	
	echo '<div><h3>'.$nom_img.' :</h3><input type="number" name="'. $dossier_nom_img .'" placeholder="0" /><br/><img src="'.$picto.'" width ="150" border="1"><br/><br/></div>';
}
echo '<input type="submit" value="Créer une grille" /> </form>';
}

function CreationGrille($liste_picto_complet)
{
	$nombre_picto_grille = count($liste_picto_complet, COUNT_RECURSIVE);
	$delta_grille = 0;
	$delta_largeur = 0;
	$delta_hauteur = 0;
	$i=0;
	while($i < $nombre_picto_grille)//boucle grilles
	{
		for($ng = 0; $ng < ceil($nombre_picto_grille/35); $ng++)
		{
			$grille = imagecreatetruecolor(1500, 2100);
			$blanc = imagecolorallocate ($grille, 255, 255, 255);
			imagefill($grille, 0, 0, $blanc);
			$nomgrille = date("YmdHis").'-grille-'.$ng.'.jpg';
			$liengrille = "grilles/$nomgrille";
			$delta_largeur = 0;
			$delta_hauteur = 0;
		
			for($lin = 0; $lin<7; $lin++)
			{
;
				for($cel = 0; $cel < 5; $cel++)
				{
				$add_picto = imagecreatefromjpeg($liste_picto_complet[$i]);
				imagecopymerge($grille, $add_picto, $delta_largeur, $delta_hauteur, 0, 0, 300, 300, 100);
				$delta_largeur = $delta_largeur + 300;
				$i++;
				if(empty($liste_picto_complet[$i]))
				{
					break 3;
				}
					echo "$add_picto";	
				}
			$delta_largeur = 0;	
			$delta_hauteur = $delta_hauteur + 300;	
			}	
			imagejpeg($grille, $liengrille);		
		}	
		imagejpeg($grille, $liengrille);

	}
	return;
}






?>

