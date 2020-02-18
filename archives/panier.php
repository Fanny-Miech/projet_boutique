<?php
include ("fonctions.php");//appelle la page fonction
//nouvelle variable
$monPanier;
//définition des variables : les variables sont des tableaux de strings
$art1 = ["Grande muraille de Chine","1000 €","images/muraille_de_chine.jpg"];
$art2 = ["Machu Picchu","1200 €","images/matchu_pitchu.jpg" ];
$art3 = ["Taj Mahal", "1300 €", "images/taj_mahal.jpg"];

//transforme le nom des articles en string pour l'appel en $_POST
$nom1 = str_replace(' ', '_', $art1[0]);
$nom2 = str_replace(' ', '_', $art2[0]);
$nom3 = str_replace(' ', '_', $art3[0]);

//ajoute cette valeur aux tableaux article
$art1[] = $nom1;
$art2[] = $nom2;
$art3[] = $nom3;

$catalogue = [$art1, $art2, $art3];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mon panier</title>
</head>

<body>
<h1>Mon panier</h1>
<?php
var_dump($_POST);
        die;?>

<?php
//pour chaque article du catalogue
foreach ($catalogue as $article) {

    //je vérifie s'il a été coché
    if (isset($_POST[$article[3]])) {
        

        //si oui, afficher article
        afficheArticle($article[0],$article[2],$article[1]);
        $monPanier[] = $article;
    }
}
echo '<br/>.<br/>';
totalPanier($monPanier);


?>

</body>
</html>