<?php 

include 'fonctions.php';//appelle la page fonction
include 'class.php'; //appelle les classes
include 'connectBdd.php'; //appelle la base de données 
include 'sql.php'; //appelle la page des requêtes sql à la bdd

//=================================================================

$erreur = true;
//nouvelles variables
$monPanier = array();
$quantité_init = '1';

session_start();

//==============================================================
//================== REMPLISSAGE DU PANIER ==================
//================================================================

//Si il y a un $_POST["add"] -> j'ajoute un $id à mon panier (avec un quantité initialisée à 1)
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
     foreach($_POST["delete"] as $key=>$id){
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
        var_dump($_POST);
        //afficher le panier
        displayPanier($_SESSION['panier'],$bdd);
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