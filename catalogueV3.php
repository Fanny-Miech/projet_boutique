<?php 
include ("fonctions.php");//appelle la page fonction

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

<body>

<header>
<h1>Les merveilles du monde</h1>
</header>

<div>
<!-- crée un formulaire -->

<form method="post" action="panier.php">
<?php 
foreach ($catalogue as $article) {?>
<div>
<input type="checkbox" name="case" id="case" /> 
<label for="case"><?php afficheArticle ($article[0],$article[2],$article[1]); }?></label>
</div>

<input type="submit" value="ajouter au panier" />
<form>
</div>


<?php //Appelle plusieurs fonctions pour afficher les artcicles
 afficheArticle1();
 afficheArticle2();
 afficheArticle3();Autre
?>
<br />
<br />


<?php //Appelle une fonction pour afficher chaque article
foreach ($catalogue as $article) {
    afficheArticle ($article[0],$article[2],$article[1]);
}
?>


</body>
</html>