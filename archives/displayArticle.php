


 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php
// Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0)
{
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['photo']['size'] <= 1000000)
        {
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['photo']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                    move_uploaded_file($_FILES['photo']['tmp_name'], 'images/destination/' . basename($_FILES['photo']['name']));
                    echo "L'envoi a bien été effectué !";
                }
        }
}
?>

<h2>Destination = <?php echo htmlspecialchars($_POST['nom']); ?></h2>

<img src="images/destination/<?php echo $_FILES['photo']['name']; ?>" alt="<?php echo $_FILES['photo']['name']; ?>">

<h2>Prix = <?php echo htmlspecialchars($_POST['prix']); ?> €</h2>

    
</body>
</html>