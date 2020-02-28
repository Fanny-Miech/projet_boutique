<?php 
session_start();
include ("fonctions.php");//appelle la page fonction

//appelle la base de données 
include 'connectBdd.php';

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

//REMPLISSAGE DU PANIER

//Si il y a un $_POST
if (!empty($_POST)) {
    //pour chaque article du catalogue
    $reponse = $bdd->query('select * from articles');
    while ($donnees = $reponse -> fetch()) {

    //si j'ai un POST => traiter le post pour créer le panier
        if (isset($_POST[$donnees['id']]) && !isset($_POST['supprimer_' . $donnees['id']])) {
            //si oui, ajouter l'article au panier
            $monPanier[] = $donnees;
    
            //initialise la quantité des artcicles à 1 =======> à l'envers
            foreach ($monPanier as $key => $article) {
                if (isset($_POST['quantite_de_' . $article['id']])) {
                    $monPanier [$key]['quantity'] = $_POST['quantite_de_' . $article['id']];
                } else {
                    $monPanier [$key]['quantity']= $quantité_init;
                }
            }
    
            //je teste si la quantité est bonne ========> ok
            foreach ($monPanier as $key => $article) {
                //si j'ai une quantité
                if (isset($_POST['quantite_de_' . $article['id']])) {
                    $error = false;
                    //j'initialise ma variable pour chaque article
                    $quantite = $_POST['quantite_de_' . $article['id']];
                    //si la quantité est vide
                    if (empty($quantite)) {
                        //j'initialise mon message d'erreur
                        echo "Entrez une quantité pour" . $article['name'];
                        $erreur = true;
                    } else {
                        $monPanier[$key]['quantity'] = $quantite;
                    }
                }
            }
        }
    }
}
//====================================================================================

//si je n'ai pas de $_POST et j'ai une $_SESSION => inclure la session dans le panier =====>ok
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


//REINITIALISATION DE $monPanier
$quantite = "";
$errquantite = "";

include ("entete.php"); //appelle la page d'entete

//===============================================================================
?>


<h1>Mon panier</h1>


<!-- crée un formulaire avec les différents articles du catalogue-->
<div>

    <form class="card-formulaire" method="post" action="panier_bdd.php">
        <?php
        //pour chaque article de mon panier
        foreach ($monPanier as $article) { ?>
        <div class="card-formulaire">
            <!-- créer un champ caché pour garder le nom de l'article -->
            <input type="hidden" name="<?php echo $article['id']; ?>" id="<?php echo $article['id'] ?>">

             <!-- j'affiche chaque article et lie le tableau article aux boutons de saisie-->
             <label for="Quantité"><?php afficheArticle($article['name'], $article['image'], $article['price']) ?>

            <!-- créer un champ 'quantité'-->
         Quantité
            <input type="number" name="<?= 'quantite_de_' . $article['id']; ?>" id="<?= 'quantite_de_' . $article['id']; ?>"
                   value="<?= $article['quantity'] ?>"/>
<br><br>
            <!-- créer un bouton 'supprimer'-->
            Supprimer l'article
            <input class="checkbox" type="checkbox" name="<?= 'supprimer_' . $article['id']; ?>" value="supprimer">

            </label>

        </br></br><HR>
            <?php } ?>

        </div>

        <!-- ===================================================================================== -->
           
        <?php
        echo '<br/>.<br/>';
        //si mon panier est vide j'écris 'le panier est vide'
        if (empty($monPanier)) {
            echo 'Le panier est vide </br>';
        } //sinon afficher le total
        else {
            echo '<h3> Total Panier : '.totalPanier($monPanier).' €</h3>';
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