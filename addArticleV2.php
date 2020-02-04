<?php
include ("fonctions.php");//appelle la page fonction

$valeur_prix=null;
$valeur_nom=null;
$message_erreur = '';
$erreur=false;
?>

<?php

// si j'ai des paramètres
if (isset ($_POST['nom'])) {
    $erreur = testDestination();
    if ($erreur) { 
        $message_erreur='Veuillez saisir une destination' . '<br />';
    }
    else {
        $valeur_nom=htmlspecialchars($_POST['nom']);
    }
}


if (isset ($_POST['prix']))
    $erreur = testPrix();
    if ($erreur) { 
        $message_erreur=($message_erreur . 'Veuillez saisir un prix' . '<br />');
    }
    //else {
     //   $valeur_prix == (int)($_POST['prix']);
    //}
   


if (isset($_FILES['photo'])) {
    $erreur = testImage();
    
            if ($erreur) { 
                $message_erreur=($message_erreur . 'Veuillez choisir une image');
            }
            elseif (empty($message_erreur)) { 
                ?>
                <h2>Destination = <?php echo htmlspecialchars($_POST['nom']); ?></h2>

                <img src="images/destination/<?php echo $_FILES['photo']['name']; ?>" alt="<?php echo $_FILES['photo']['name']; ?>">

                <h2>Prix = <?php echo htmlspecialchars($_POST['prix']); ?> €</h2>
           <?php
            }
            

  echo $message_erreur;  
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


<!-- Affiche le formulaire-->

<form method="post" action="addArticleV2.php" enctype="multipart/form-data">
 
<p>
<h2>Formulaire d'envoi d'une nouvelle destination</h2><br />
<br />
<h3>Destination</h3> 
<input type="text" name="nom" value="<?php $valeur_nom ?>" /> <br />
<br />
<br />
<h3>Photo</h3>
<input type="file" name="photo"/><br />
<br />
<br />
<h3>Prix </h3>
<input type="number" name="prix" placeholder="entier entre 0 et 10 000" value= "<?php $valeur_prix ?>" /><br />
<br />
<br />
<input type="submit" value="Envoyer"> <br />
</p>
 
</form>
    
</body>
</html>