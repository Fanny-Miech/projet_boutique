<?php
include('fonction_requete_sql.php'); //appelle la page fonction

//appelle la base de données 
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bd_boutique;charset=utf8', 'fanny.miech', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}


echo '<h3> Liste des articles dans le catalogue </h3> </br>';
list_articles($bdd);

echo '</br> </br><h3> Produits en rupture de stock </h3> </br>';
rupture_de_stock($bdd);

echo '</br> </br><h3> Liste des articles de la commande 1 </h3> </br>';
commande_1($bdd);

echo '</br> </br><h3> Liste des commandes passées par Charlize </h3> </br>';
commandes_charlize($bdd);

echo '</br> </br><h3> Ajouter un client à la liste. </h3></br>';
$client=['alibaba', 'ali.baba@40voleurs.com', 'ebjhvse', 35000, 'asialand'];
ajouter_client($bdd, $client);
echo '</br></br> Nouvelle liste des clients :</br>';
list_clients($bdd);


echo '</br> </br><h3> Supprimer les clients sans commande </h3> </br>';
suppr_client($bdd);
list_clients($bdd);


?>