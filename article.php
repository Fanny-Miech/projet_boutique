<?php 
//définition des variables : les variables sont des strings
$nom = "grande muraille de Chine";
$prix = "1000 €";
$photo = "images/muraille_de_chine.jpg";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Boutique</title>
</head>
<header>
<h1>Les merveilles du monde</h1>
</header>
<body>
<!--affiche le nom de l'article-->
<h2>La <?php echo $nom; ?></h2>
<div>
<!--affiche l'image variable de l'artcicle-->
<img src="<?php echo $photo;?>" alt="">
</div>
<!--affiche le prix -->
<p>Pour seulement <span><?php echo $prix; ?> </span> , venez découvrir la <?php echo $nom; ?>.</p>

</body>
</html>