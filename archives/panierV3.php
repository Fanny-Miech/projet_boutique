<?php
session_start();

$erreur = true;


var_dump($_POST);

include("fonctions.php");//appelle la page fonction
//nouvelle variable
$monPanier = array();

//définition des variables : les variables sont des tableaux de strings
$art1 = ["Grande muraille de Chine", "1000 €", "images/muraille_de_chine.jpg"];
$art2 = ["Machu Picchu", "1200 €", "images/machu_picchu.jpg"];
$art3 = ["Taj Mahal", "1300 €", "images/taj_mahal.jpg"];

//transforme le nom des articles en string pour l'appel en $_POST
$nom1 = str_replace(' ', '_', $art1[0]);
$nom2 = str_replace(' ', '_', $art2[0]);
$nom3 = str_replace(' ', '_', $art3[0]);

//ajoute cette valeur au tableau articles
$art1[] = $nom1;
$art2[] = $nom2;
$art3[] = $nom3;

$catalogue = [$art1, $art2, $art3];

$quantité_init = '1';


//REMPLISSAGE DU PANIER
//pour chaque article du catalogue
foreach ($catalogue as $article) {

//================================================================================================

    //si j'ai un POST et pas de session => traiter le post pour créer le panier
    if (isset($_POST[$article[3]]) && !isset($_POST['supprimer_' . $article[3]]) && (empty($_SESSION))) {

        //si oui, ajouter l'article au panier
        $monPanier[] = $article;

        //initialise la quantité des artcicles à 1
        foreach ($monPanier as $key => $article) {
            if (isset($_POST['quantite_de_' . $article[3]])) {
                $monPanier [$key][] = $_POST['quantite_de_' . $article[3]];
            } else {
                $monPanier [$key][] = $quantité_init;
            }
        }
    

        //je teste si la quantité est bonne
        foreach ($monPanier as $key => $article) {
            //si j'ai une quantité
            if (isset($_POST['quantite_de_' . $article[3]])) {
                $error = false;
                //j'initialise ma variable pour chaque article
                $quantite = $_POST['quantite_de_' . $article[3]];
                //si la quantité est vide 
                if (empty($quantite)) {
                    //j'initialise mon message d'erreur
                    echo "Entrez une quantité pour" . $article[0];
                    $erreur = true;
                } else {
                    $monPanier[$key][4] = $quantite;

                }
            }
        }
    }

//====================================================================================

    //si je n'ai pas de $_POST et j'ai une session => inclure la session dans le panier
    elseif (empty ($_POST[$article[3]]) && (!empty($_SESSION['panier']))) {
        foreach ($_SESSION['panier'] as $articleP) {
            $monPanier[]= $artricleP;
        }
    }

//=====================================================================================

    //si j'ai un POST et une SESSION => écraser la session avec le nouveau panier
    elseif (isset($_POST[$article[3]]) && (!empty($_SESSION['panier']))) {

        //initialise la quantité des artcicles à 1
        foreach ($monPanier as $key => $article) {
            if (isset($_POST['quantite_de_' . $article[3]])) {
                $monPanier [$key][] = $_POST['quantite_de_' . $article[3]];
            } else {

                $monPanier [$key][] = $quantité_init;
            }
        }

        //je teste si la quantité est bonne
        foreach ($monPanier as $key => $article) {
            //si j'ai une quantité
            if (isset($_POST['quantite_de_' . $article[3]])) {
                $error = false;
                //j'initialise ma variable pour chaque article
                $quantite = $_POST['quantite_de_' . $article[3]];
                //si la quantité est vide 
                if (empty($quantite)) {
                    //j'initialise mon message d'erreur
                    echo "Entrez une quantité pour" . $article[0];
                    $erreur = true;
                } else {
                    $monPanier[$key][4] = $quantite;

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

    <form method="post" action="panierV3.php">
        <?php
        //pour chaque article de mon panier
        foreach ($monPanier as $article) { ?>
        <div>
            <!-- créer un champ caché pour garder le nom de l'article -->
            <input type="hidden" name="<?php echo $article[3]; ?>" id="<?php echo $article[0] ?>">

            <!-- créer un champ 'quantité'-->
         Quantité
            <input type="number" name="<?= 'quantite_de_' . $article[3]; ?>" id="<?= 'quantite_de_' . $article[3]; ?>"
                   value="<?= $article[4] ?>"/>
<br><br>
            <!-- créer un bouton 'supprimer'-->
            Supprimer l'article
            <input type="checkbox" name="<?= 'supprimer_' . $article[3]; ?>" value="supprimer">

            <!-- j'affiche chaque article et lie le tableau article aux boutons de saisie-->
            <label for="Quantité"><?php afficheArticle($article[0], $article[2], $article[1]) ?> </label>
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