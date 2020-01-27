<html>
  <body>
    <form enctype="multipart/form-data" action="" method="post">
   
      Transfère le fichier <input type="file" name="monfichier" /><BR/>
	  <label for="nom_image">Nom de l'image</label>
	  	  <input type="text" id="name" name="nom_image" required maxlength="255" >
      <input type="submit" />
    </form>
<?php
include_once 'function.php';
if(!empty($_POST))
{
	$nom = $_POST['nom_image'];
	$nomOrigine = $_FILES['monfichier']['name'];
	$elementsChemin = pathinfo($nomOrigine);
	$extensionFichier = $elementsChemin['extension'];
	$extensionsAutorisees = array("jpeg", "jpg", "JPG", "JPEG", "png", "PNG");
	if (!(in_array($extensionFichier, $extensionsAutorisees))) 
	{
		echo "Le fichier n'a pas l'extension attendue";
	} 
	else 
	{    
	// Copie dans le repertoire du script avec un nom
	// incluant l'heure a la seconde pres 
	$repertoireDestination = dirname(__FILE__)."/image/";
	$nombrut = $nom.date("YmdHis");
	$nomDestination = $nombrut.".".$extensionFichier;
	
		if (move_uploaded_file($_FILES["monfichier"]["tmp_name"], $repertoireDestination.$nomDestination)) //on vérifie si on arrive a enregistrer le fichier
		{
		echo 'Le fichier '.$nomDestination.' a été enregistré et l _extention est '.$extensionFichier.'  fscsd';
			if ($extensionFichier == "png" || $extensionFichier == "PNG")
			{
				echo "hello l'extension est $extensionFichier";
				Convert_Png($nomDestination,$repertoireDestination,$nombrut);
				echo "image convertie en png";
			}
			else
			{
				Convert_jpg($nomDestination,$repertoireDestination,$nombrut);
				//echo "image convertie en jpg";
			}
		echo "maintenant on recadre";
		Recadrage_Image($nombrut,$repertoireDestination,$extensionFichier,$nom);
		echo "image enregistrée";
		} 
		else 
		{
		echo "Le fichier n'a pas été uploadé (trop gros ?) ";
		}
	}
}
else
{
//echo "coucou rien";
}
	
?>

<h2>Liste des images </h2>
<a href="grille.php"> Créer une Grille </a>
  </body>
</html>
<?php
