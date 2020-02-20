<?php 
session_start();
include ("fonctions.php");//appelle la page fonction
var_dump ($_SESSION['panier']);


//appelle la base de données 
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bd_boutique;charset=utf8', 'fanny.miech', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

//===============================================================================

include ("entete.php"); //appelle la page d'entete

//===============================================================================

// Ajoute un User à la BDD
$req1 = $bdd->prepare('INSERT INTO users(name, email, adress, postal_code, city) 
VALUES(:name, :email, :adress, :postal_code, :city)');
$req1->execute(array(
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'adress' => $_POST['adress'],
    'postal_code' => $_POST['postal_code'],
    'city' => $_POST['city']
    ));
$req1->closeCursor();
echo "<h3>Le client ".$_POST['name']." est enregistré.</h3>";

//=============================================================================


echo "<h3> La commande n° 0000512 sera livrée à l'adresse suivante : ". $_POST['adress'] .' à '. $_POST['city'].'.</h3>';
echo '<h2> Merci de renseigner votre numero de carte bleue. </h2>';

//calcule le total des weight de la commande
$totalW=0;
foreach ($_SESSION['panier'] as $article) {
    $totalW+=floatval($article['weight'])*intval($article['quantity']);
}
var_dump($totalW);
var_dump(last_users_id($bdd));
var_dump(current_date($bdd));

//ajoute une commande à la BDD
$req2 = $bdd->prepare('INSERT INTO orders(numero, date, price, total_weight, Users_id) 
VALUES(:numero, :date_actuelle, :price, :total_weight,:last_id)');
$req2->execute(array(
    'numero' => 0000512,
    'date_actuelle' =>  current_date($bdd),
    'price' => totalPanier($_SESSION['panier']),
    'total_weight' => $totalW,
    'last_id' => last_users_id($bdd)
    ));
$req2->closeCursor();


//echo 'La commande '. $req2['numero']. 'a été enregistrée le '.$req2['date']'.';

//==================================================================================

//Ajoute des articles à la commande
foreach ($_SESSION['panier'] as $articles) {
    $req3 = $bdd->prepare('INSERT INTO articles_commandes(Articles_id, Orders_id, quantity) 
VALUES(:Articles_id, :last_id, :quantity)');
    $req3->execute(array(
    'Articles_id' => $articles['id'],
    'last_id' => last_orders_id($bdd),
    'quantity' => $articles['quantity']
     ));
     $req3->closeCursor();
}
?>