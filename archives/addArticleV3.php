<?php
$valeur_prix="";
$valeur_nom="";
$valeur_photo="";
$message_erreur = '';
$erreur=true;



    // si j'ai soumis mon formulaire
    if (isset ($_POST['nom'])) {

        $erreur=false;

       //je teste ma destination
        if (intval($_POST['nom'])!=0 || empty($_POST['nom'])) { 
            //  si la destination n'est pas un nom ou est vide il y a une erreur
            $erreur= true;
            $message_erreur='Veuillez saisir une destination' . '<br />';
        }
        else {
            //si je n'ai pas d'erreur je veux garder la donnée saisie
            $valeur_nom=htmlspecialchars($_POST['nom']);
        }
        
   
     // je teste mon prix
        if (intval($_POST['prix'])<=0 || empty($_POST['prix'])) {
            // si le prix est vide ou s'il n'est pas correct --> erreur
            $erreur= true;
            $message_erreur=($message_erreur . 'Veuillez saisir un prix' . '<br />');
        }
        else {
            // si pas d'erreur je veux garder la donnée saisie
            $valeur_prix=htmlspecialchars($_POST['prix']);
        }

      //je teste mon image
        if ($_FILES['photo']['name']=="") {
            //si mon image est vide
            $erreur = true;
            $message_erreur=($message_erreur . 'Veuillez choisir une image svp' . '<br />');
        }
        elseif ($_FILES['photo']['error'] == 0)
        {
            // je teste si le fichier n'est pas trop gros
            if ($_FILES['photo']['size'] <= 1000000)
            {
                // je teste si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['photo']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                    //si tout est ok : je télécharge l'image dans 'images/destinations/'
                    move_uploaded_file($_FILES['photo']['tmp_name'], 'images/destination/' . basename($_FILES['photo']['name']));
                    // et je veux garder la donnée saisie
                    $valeur_photo = 'images/destination/'.basename($_FILES['photo']['name']);
                }
                else {
                    //sinon il y a une erreur
                    $erreur = true;
                    $message_erreur=($message_erreur . 'Veuillez choisir une image');
                }
            }
        
        }
    
    }

 
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulaire</title>
</head>
<body>

<?php
//s'il y a des erereurs
    if ($erreur) {

           // ecrire le message d'erreur
            echo $message_erreur; 
?>
   <!-- Affiche le formulaire-->

   <form method="post" action="addArticleV3.php" enctype="multipart/form-data">
   <div class="form-group">

   <h2>Formulaire d'envoi d'une nouvelle destination</h2><br />
   <br />
   <h3>Destination</h3> 
   <input type="text" name="nom" value="<?php echo $valeur_nom; ?>" /> <br />
   <br />
   <br />
   <h3>Photo</h3>
   <input type="file" name="photo" value= "<?php echo $valeur_photo; ?>"/><br />
   <br />
   <br />
   <h3>Prix </h3>
   <input type="number" name="prix" placeholder="entier entre 0 et 10 000" value= "<?php echo $valeur_prix; ?>" /><br />
   <br />
   <br />
   <input type="submit" value="Envoyer"> <br />

   </div>
   </form>

<?php
    }

else {
    //si je n'ai pas d'erreur
    // afficher l'article
    ?>
    <h2>Destination = <?php echo htmlspecialchars($_POST['nom']); ?></h2>

    <img src="images/destination/<?php echo $_FILES['photo']['name']; ?>" alt="<?php echo $_FILES['photo']['name']; ?>">

    <h2>Prix = <?php echo htmlspecialchars($_POST['prix']); ?> €</h2>
    <?php
    }  
?>
    
</body>
</html>