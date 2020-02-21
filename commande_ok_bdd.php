<?php 
session_start();
include ("fonctions.php");//appelle la page fonction

//var_dump ($_SESSION['panier']);

//=================================================================
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

//supprime les clients sans commande
suppr_client($bdd);



// Ajoute un User à la BDD  ========== ATTENTION ===> Tester les $_POST !!!!!!
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

$num_commande=(bin2hex(random_bytes(5)));//ATTENTION ===> Vérifier si $num_commande existe déjà !
//var_dump($num_commande);


echo "<h3> La commande n° ".$num_commande." sera livrée à l'adresse suivante : ". $_POST['adress'] .' à '. $_POST['city'].'.</h3>';
echo '<h2> Merci de renseigner votre numero de carte bleue. </h2>';

//calcule le total des weight de la commande
$totalW=0;
foreach ($_SESSION['panier'] as $article) {
    $totalW+=floatval($article['weight'])*intval($article['quantity']);
}

// var_dump($totalW);

//$today = date("Y-m-d");
 $today=today_date($bdd);
// var_dump($today);

 $userId=last_users_id($bdd);
// var_dump($userId);

 $orderId=last_orders_id($bdd);
// var_dump($orderId);


//ajoute une commande à la BDD
$req2 = $bdd->prepare('INSERT INTO orders(numero, date, price, total_weight, Users_id) 
VALUES(:numero, :date_actuelle, :price, :total_weight,:last_id)');
$req2->execute(array(
    'numero' => $num_commande,
    'date_actuelle' => $today,
    'price' => totalPanier($_SESSION['panier']),
    'total_weight' => $totalW,
    'last_id' => intval($userId)
    ));
$req2->closeCursor();



//==================================================================================

//Ajoute des articles à la commande
foreach ($_SESSION['panier'] as $articles) {
    $req3 = $bdd->prepare('INSERT INTO articles_commandes(Articles_id, Orders_id, quantity) 
VALUES(:Articles_id, :last_id, :quantity)');
    $req3->execute(array(
    'Articles_id' => $articles['id'],
    'last_id' => intval($orderId),
    'quantity' => $articles['quantity']
     ));
     $req3->closeCursor();
}

?>
</body>
<?php
include ("footer.php");
?>
</html>