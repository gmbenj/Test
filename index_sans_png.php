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
	$extensionsAutorisees = array("jpeg", "jpg", "JPG", "JPEG");
	$repertoireDestination = dirname(__FILE__)."/image/";
	$nomDestination = $nom.date("YmdHis");
	
	if (!(in_array($extensionFichier, $extensionsAutorisees))) 
	{
		if ($extensionFichier = "png" || "PNG")
		{
		Convert_Png($nomDestination,$repertoireDestination,$nom);
		echo "le rep d'originier est $elementsChemin$nomOrigine Le fichier est png et $repertoireDestination et le nom est $nom et le nom d'origine est $nomDestination";
		}
		else
		{
		echo "Le fichier n'a pas l'extension attendue";
		}
	} 
	else 
	{    
	// Copie dans le repertoire du script avec un nom
	// incluant l'heure a la seconde pres 


	
	if (move_uploaded_file($_FILES["monfichier"]["tmp_name"], $repertoireDestination.$nomDestination."jpg")) 
		{
		Recadrage_Image($nomDestination,$repertoireDestination,$extensionFichier);
		echo 'Le fichier '.$nomDestination.' a été enregistré fonction recadrage';
				
	} 
		else 
		{
		echo "Le fichier n'a pas été uploadé (trop gros ?) ";
	}
	}
}
else
{
echo "coucou rien";
}
	
?>
  </body>
</html>
<?php
