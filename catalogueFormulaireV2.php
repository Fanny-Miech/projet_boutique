<?php 
session_start();
include ("fonctions.php");//appelle la page fonction

//définition des variables : les variables sont des tableaux de strings
$art1 = ["Grande muraille de Chine","1000 €","images/muraille_de_chine.jpg"];
$art2 = ["Machu Picchu","1200 €","images/matchu_pitchu.jpg" ];
$art3 = ["Taj Mahal", "1300 €", "images/taj_mahal.jpg"];

$catalogue = [$art1, $art2, $art3];

include ("entete.php"); //appelle la page d'entete
?>


<header>
<h1>Les merveilles du monde</h1>
</header>

<div>
<!-- crée un formulaire avec les différents articles du catalogue-->

<form method="post" action="panierV2.php">
<?php 
foreach ($catalogue as $article) {?>
<div>

<input type="checkbox" name="<?php echo $article[0] ?>" id="<?php echo $article[0] ?>" /> 
<label for="<?php echo $article[0] ?>"><?php afficheArticle ($article[0],$article[2],$article[1]); }?></label>

</div>

<input type="submit" value="Ajouter au panier" />
<form>
</div>


</body>
</html>