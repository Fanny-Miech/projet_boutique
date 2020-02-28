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

//====================================================================================

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
        displayPanier($_SESSION['panier'],$bdd);
        echo '<br/>.<br/>';
        //si mon panier est vide j'écris 'le panier est vide'
        if (empty($_SESSION['panier'])) {
            echo 'Le panier est vide </br>';
        } //sinon afficher le total
        else {
            if ($_SESSION['panier']->totPanier($bdd)==0) {
                echo '<h2>Le panier est vide.</h2>';
            }
            else{
                echo '<h3> Total Panier : '.$_SESSION['panier']->totPanier($bdd).' €</h3>';
            }
            
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
        foreach ($_SESSION['panier']->getPanier() as $id=>$qte) { ?>
            
            <!-- créer un champ caché pour garder l'id de l'article -->
            <input type="hidden" name="<?=$id; ?>" id="<?= $id;?>">
            
            <!-- créer un champ caché pour garder la quantité de l'article -->
            <input type="hidden" name="<?= $qte; ?>" id="<?= $qte; ?>">
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