<?php 

include ("fonctions.php");//appelle la page fonction
include ("class.php");

//appelle la base de données 
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bd_boutique;charset=utf8', 'fanny.miech', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

//=================================================================

$erreur = true;
//nouvelles variables
$monPanier = array();
$quantité_init = '1';


//=======================================================================================

//0. On récupère notre catalogue        OK
//1. On restaure notre panier depuis POST = on va stocker le produit correspondant à chacun des id
//1.1. On boucle sur notre catalogue
//1.2 Pour chaque produit du catalogue, on regarde si il est dans notre liste d'ids, si oui on l'ajoute au panier
//1.3 Si le produit est dans notre panier on va chercher sa quantité et on l'ajoute au panier
//2. On affiche le panier               OK
//3. On sauvegarde la panier en SESSION OK

//================================================================================================
session_start();
//REMPLISSAGE DU PANIER
//Si il y a un $_POST

if (!empty($_POST["add"])) {
   foreach($_POST["add"] as $id)
   {
       $_SESSION['panier']->add($id);
   }
}

if (!empty($_POST["update"])) {
    foreach($_POST["update"] as $id=>$qte)
    {
        $_SESSION['panier']->update($id, $qte);
    }
 }

 if (!empty($_POST["delete"])){
     foreach($_POST["update"] as $id){
         $_SESSION['panier']->delete($id);
     }
 }
/*
//====================================================================================

//si je n'ai pas de $_POST et j'ai un $_SESSION => inclure la session dans le panier =====>ok
elseif (!empty($_SESSION['panier'])) {
    $monPanier = $_SESSION['panier'];
}


//================================================================================

//Si pas de $_SESSION et pas de $_POST ==> écrire le panier est vide
else {
    echo '<h3>Le panier est vide.</h3>';
}

//réinitialisation de $_SESSION ====> ok
$_SESSION['panier'] = $monPanier;

//=============================================================================


//var_dump($_SESSION);
//var_dump($monPanier);
*/

//REINITIALISATION DE $monPanier
$quantite = "";
$errquantite = "";

include ("entete.php"); //appelle la page d'entete

//===============================================================================
?>


<h1>Mon panier</h1>


<!-- crée un formulaire avec les différents articles du catalogue-->
<div>

    <form class="card-formulaire" method="post" action="panier_objet.php">
        <?php
        //afficher le panier
        displayPanier($_SESSION['panier']);
        echo '<br/>.<br/>';
        //si mon panier est vide j'écris 'le panier est vide'
        if (empty($_SESSION['panier'])) {
            echo 'Le panier est vide </br>';
        } //sinon afficher le total
        else {
            echo '<h3> Total Panier : '.$_SESSION['panier']->totPanier().' €</h3>';
        }

        ?>
        <br>
        <!--submit : soumettre le formulaire-->
        <input class="btn btn-default btn-lg" type="submit" name="recalculer" value="Recalculer"/>


    </form>

    <!-- ============================================================================================ -->


<!-- Nouveau formulaire pour valider la commande-->
    <form class="card-formulaire" method="post" action="commande_bdd.php">
    <?php
        //pour chaque article de mon panier
        foreach ($monPanier as $article) { ?>
            
            <!-- créer un champ caché pour garder l'id de l'article -->
            <input type="hidden" name="<?php echo $article['id']; ?>" id="<?php echo $article['id'] ?>">
            
            <!-- créer un champ caché pour garder la quantité de l'article -->
            <input type="hidden" name="<?php echo $article['quantity']; ?>" id="<?php echo $article['quantity'] ?>">
            <?php
        }?>
    </br><br>

        <h2> Valider la commande </h2>
        <!-- envoyer la commande-->
        <input class="btn btn-primary btn-lg" type="submit" name="valider" value="Valider"/>
    </form>
    </br></br></br>

</div>


</body>
<?php
include ("footer.php");
?>
</html>