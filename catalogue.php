<?php 
//définition des variables : les variables sont des tableaux de strings
$noms = ["Grande muraille de Chine","Machu Picchu", "Taj Mahal"];
$prix = ["1000 €", "1200 €", "1300 €"];
$photos = ["images/muraille_de_chine.jpg", "images/matchu_pitchu.jpg", "images/taj_mahal.jpg"];
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
for ($i = 0; $i < count($noms); $i++) {
    echo $noms[$i];?>
    <br />
    <img src="<?php echo $photos[$i]; ?>" alt="<?php echo $noms[$i]; ?>">
    <br />
    Pour seulement <?php echo $prix[$i];?>
    <br />
<?php  
}
?>

</body>
</html>