<p>salut</p>
<?php
if(isset($_FILES['fichier']))
{ 	 echo "salut";
     $dossier = '/home/aurel/sites/photo_dublin/';
    // $fichier = basename($_REQUEST['nom']);
	 echo $dossier . $fichier;
     if(move_uploaded_file($_FILES['fichier']['tmp_name'], $dossier . "Photo_Dublin_" . $fichier . ".zip")) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
          echo 'Upload effectué avec succès !';
     }
     else //Sinon (la fonction renvoie FALSE).
     {
          echo 'Echec de l\'upload !';
     }
}
else echo "ça marche pas";
?>
