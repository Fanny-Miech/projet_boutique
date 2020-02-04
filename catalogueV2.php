<?php 
//définition des variables : les variables sont des tableaux de strings
$art1 = ["Grande muraille de Chine","1000 €","images/muraille_de_chine.jpg"];
$art2 = ["Machu Picchu","1200 €","images/matchu_pitchu.jpg" ];
$art3 = ["Taj Mahal", "1300 €", "images/taj_mahal.jpg"];

$catalogue = [$art1, $art2, $art3];

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

<?php 
//pour chaque artcle du catalogue faire :
foreach ($catalogue as $article) {
   echo $article [0];?> <!-- écrire le nom de l'article-->
<br />
<img src="<?php echo $article[2]; ?>" alt="<?php echo $article[0]; ?>"><!-- afficher l'image de l'article-->
<br />
Pour seulement <?php echo $article[1];?><!-- écrire le prix de l'article-->
<br />
<?php  
}
?>





</body>
</html>