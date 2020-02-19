<?php 
session_start();
include ("fonctions.php");//appelle la page fonction

//appelle la base de données 
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bd_boutique;charset=utf8', 'fanny.miech', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

include ("entete.php"); //appelle la page d'entete
?>


<header>
<h1>Notre catalogue</h1>
</header>

<div>
<!-- crée un formulaire avec les différents articles du catalogue-->

<form method="post" action="panierV4_bdd.php">
<?php 

$reponse = $bdd->query('select * from articles');
    while ($donnees = $reponse -> fetch())
    {?>
        <div>

        <input type="checkbox" name="<?php echo $donnees['id'] ?>" id="<?php echo $donnees['id'] ?>" />Sélectionner l'article</input>
        <label for="<?php echo $donnees['id'] ?>"><?php afficheArticle($donnees['name'], $donnees['image'], $donnees['price']); }?></label>

        </div>

        <input type="submit" value="Ajouter au panier" />
        <form>
        </div>

</body>
</html>