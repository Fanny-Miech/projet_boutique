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

//=================================================================

$erreur = true;
//nouvelles variables
$monPanier = array();
$quantité_init = '1';


//REMPLISSAGE DU PANIER
//pour chaque article du catalogue
//foreach ($catalogue as $article) {
$reponse = $bdd->query('select * from articles');
while ($donnees = $reponse -> fetch())
{
//================================================================================================

    //si j'ai un POST et pas de session => traiter le post pour créer le panier
    if (isset($_POST[$donnees['id']]) && !isset($_POST['supprimer_' . $donnees['id']]) && (empty($_SESSION))) {

        //si oui, ajouter l'article au panier
        $monPanier[] = $donnees;

        //initialise la quantité des artcicles à 1
        foreach ($monPanier as $key => $article) {
            if (isset($_POST['quantite_de_' . $article['id']])) {
                $monPanier [$key]['quantity'] = $_POST['quantite_de_' . $article['id']];
            } else {
                $monPanier [$key]['quantity']= $quantité_init;
            }
        }
    

        //je teste si la quantité est bonne
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

//====================================================================================

    //si je n'ai pas de $_POST et j'ai une session => inclure la session dans le panier
    elseif (empty ($_POST[$donnees['id']]) && (!empty($_SESSION['panier']))) {
        foreach ($_SESSION['panier'] as $articleP) {
            $monPanier[]= $artricleP;
        }
    }

//=====================================================================================

    //si j'ai un POST et une SESSION => écraser la session avec le nouveau panier
    elseif (isset($_POST[$donnees['id']]) && (!empty($_SESSION['panier']))) {

        //initialise la quantité des artcicles à 1
        foreach ($monPanier as $key => $article) {
            if (isset($_POST['quantite_de_' . $article['id']])) {
                $monPanier [$key]['quantity'] = $_POST['quantite_de_' . $article['id']];
            } else {

                $monPanier [$key]['quantity'] = $quantité_init;
            }
        }

        //je teste si la quantité est bonne
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

        //réinitialisation de $_SESSION
        destroy_session();
        foreach ($monPanier as $key => $article) {
            $_SESSION['panier'][] = $article;
        }
    }
}


//=============================================================================


var_dump($_SESSION);
var_dump($monPanier);



//REINITIALISATION DE $monPanier
$quantite = "";
$errquantite = "";

include ("entete.php"); //appelle la page d'entete

//===============================================================================
?>


<h1>Mon panier</h1>


<!-- crée un formulaire avec les différents articles du catalogue-->
<div>

    <form method="post" action="panierV4_bdd.php">
        <?php
        //pour chaque article de mon panier
        foreach ($monPanier as $article) { ?>
        <div>
            <!-- créer un champ caché pour garder le nom de l'article -->
            <input type="hidden" name="<?php echo $article['id']; ?>" id="<?php echo $article['id'] ?>">

            <!-- créer un champ 'quantité'-->
         Quantité
            <input type="number" name="<?= 'quantite_de_' . $article['id']; ?>" id="<?= 'quantite_de_' . $article['id']; ?>"
                   value="<?= $article['quantity'] ?>"/>
<br><br>
            <!-- créer un bouton 'supprimer'-->
            Supprimer l'article
            <input type="checkbox" name="<?= 'supprimer_' . $article['id']; ?>" value="supprimer">

            <!-- j'affiche chaque article et lie le tableau article aux boutons de saisie-->
            <label for="Quantité"><?php afficheArticle($article['name'], $article['image'], $article['price']) ?> </label>
            <?php } ?>

        </div>
        
        <?php
        echo '<br/>.<br/>';
        //si mon panier est vide j'écris 'le panier est vide'
        if (empty($monPanier)) {
            echo 'Le panier est vide';
        } //sinon afficher le total
        else {
            totalPanier($monPanier);
        }

        ?>
        <br><br><br>
        <!--submit : soumettre le formulaire-->
        <input type="submit" name="recalculer" value="Recalculer"/>
        <form>
</div>
</body>
</html>