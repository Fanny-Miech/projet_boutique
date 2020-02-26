<?php

// Cette fonction affiche l'article 1
function afficheArticle1() {
    $art1 = ["Grande muraille de Chine","1000 €","images/muraille_de_chine.jpg"];
    echo $art1[0]; // écrire le nom de l'article
    echo ('<br />');
    echo ('<img src="'.$art1[2].'" alt="'.$art1[0].'">');  //afficher l'image de l'article
    echo ('<br />');
    echo ('Pour seulement ' . $art1[1]. ' euros'); //écrire le prix de l'article
    echo ('<br />');
    echo ('<br />');
}


// Cette fonction affiche l'article 1
function afficheArticle2() {
    $art2 = ["Machu Picchu","1200 €","images/matchu_pitchu.jpg" ];
    echo $art2[0]; // écrire le nom de l'article
    echo ('<br />');
    echo ('<img src="'.$art2[2].'" alt="'.$art2[0].'">');  //afficher l'image de l'article
    echo ('<br />');
    echo ('Pour seulement ' . $art2[1]); //écrire le prix de l'article
    echo ('<br />');
    echo ('<br />');
  
}


// Cette fonction affiche l'article 1
function afficheArticle3() {
    echo '<div class="row">';
    $art3 = ["Taj Mahal", "1300 €", "images/taj_mahal.jpg"];
    echo $art3[0]; // écrire le nom de l'article
    echo ('<br />');
    echo ('<img src="'.$art3[2].'" alt="'.$art3[0].'">');  //afficher l'image de l'article
    echo ('<br />');
    echo ('Pour seulement ' . $art3[1]); //écrire le prix de l'article
    echo ('<br /> ');
    echo ('<br />');
    echo '</div>';
  
}

// Cette fonction affiche un article
function afficheArticle($nom,$image,$prix) {
    echo '</br></br><div class="card">';
    echo '<img class="card-img-top" src="'.$image.'" alt="'.$nom.'">';
    echo '<div class=card-body">';
    echo '<h2 class="card-title">'.$nom.'</h2>';
    echo '<h4 class="card-text"> Pour seulement '.$prix.' € !</h4>';
    echo '</div></div>'; 


    // echo ('<h2>'.$nom.'</h2>'); // écrire le nom de l'article
    // echo ('<br />');
    // echo ('<img src="'.$image.'" alt="'.$nom.'">');  //afficher l'image de l'article
    // echo ('<br /><br />');
    // echo ('Pour seulement ' . $prix. ' € !'); //écrire le prix de l'article
     echo ('<br />');

}


// cette fonction teste si l'image a bien été envoyée et s'il n'y a pas d'erreur
function testImage() {
if ($_FILES['photo']['error'] == 0)
{
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['photo']['size'] <= 1000000)
        {
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['photo']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                    move_uploaded_file($_FILES['photo']['tmp_name'], 'images/destination/' . basename($_FILES['photo']['name']));
                }
                else {
                    return true;
                }
        }
}
}

//cette fonction teste si le prix est bien un entier > 0 
//is_int($_POST['prix'])==false OR 
function testPrix() {
    if (intval($_POST['prix'])<=0) {
        return true;
    }
    else {
        return false;
    }

}

//cette fonction teste si le texte de la destination est bien un texte
function testDestination() {
    if (is_string($_POST['nom'])==false) {
        return true;
    }
    else {
        return false;
    }
}


//cette fonction calcule le total des articles du panier
function totalPanier($panier) {
    $total=0;
    //pour chaque article du panier
    foreach ($panier as $article){
        //ajouter le prix au total
        $total+=intval($article['price'])*intval($article['quantity']);
    }
    // echo '<h3>Total panier : '.$total. ' € </h3>';
    return $total;
}


//cette fonction vide le panier
function viderPanier(){
session_destroy();
$monPanier=null;
return $monPanier;
}

function totalWeight() {
    $total=0;
    foreach ($_SESSION['panier'] as $article) {
        $total+=intval($article['weight'])*intval($article['quantity']);
    }
    return $total;
}

//fonction qui appelle le dernier Users_id
function last_users_id($bdd) {
    $reponse = $bdd->query('SELECT id FROM users ORDER BY id DESC LIMIT 1')->fetch();
    return $reponse[0];
}

//fonction qui appelle le dernier orders_id
function last_orders_id($bdd)
{
    $reponse = $bdd->query('SELECT id FROM orders ORDER BY id DESC LIMIT 1')->fetch();
    return $reponse[0];
}

//fonction qui retourne la date du jour
function today_date($bdd){
    $reponse = $bdd->query('SELECT CURRENT_DATE')->fetch();
    $date = $reponse[0];
    return $date;
}

//cette fonction supprime les clients qui n'ont pas de commande
function suppr_client($bdd) {
    $reponse = $bdd->query('DELETE FROM users
    WHERE users.id 
    NOT IN (
        SELECT orders.Users_id
        FROM orders
        )
    ');
}

//====================================================================
//============================== FONCTIONS =================================
//====================================================================

// Cette fonction affiche un article
function displayArticle(Article $article)
{
    //d'abord récupérer les Image, Price et Name de l'article via les GETTERS
    $image=$article->getImage();
    $price=$article->getPrice();
    $name=$article->getName();

    //ensuite afficher l'article
    echo '</br></br><div class="card">';
    echo '<img class="card-img-top" src="'.$image.'" alt="'.$name.'">';
    echo '<div class=card-body">';
    echo '<h2 class="card-title">'.$name.'</h2>';
    echo '<h4 class="card-text"> Pour seulement '.$price.' € !</h4>';
    if (is_a ($article, 'Vetement')) {
        echo "<h2> Tu auras sûrement besoin d'1 ".$article->getTaille(). '...</h2>';
    }
    else if (is_a($article, 'Chaussure')){
        echo "<h2>N'oublie pas de prendre tes ".$article->getPointure().' !</h2>';
    }
    echo '</div></div>';
}

//$articleTest = new Article (15, 'blabla', 'Voyage voyage', 500, 2, 'img/pattaya.jpg', 5, 1, 3);
//var_dump($articleTest);

//=======================================================================================

//Cette fonction affiche le catalogue

function displayCat(Catalogue $catalogue)
{
    //Je crée mon formlaire d'affichage du catalogue?>
    <form method="post" action="panier_bdd.php">
   
   <?php
   //ATTENTION : on ne peut pas boucler sur un tableau !!!
   //pour chaque article de mon tableau catalogue (récupéré de l'objet catalogue via getCat)
    foreach ($catalogue->getCat() as $art) {
        //je récupère les champs stock et id de chaque article du catalogue
        $stock = $art->getStock();
        $id = $art->getId(); ?>
           
        <div class="card-formulaire">
      
            <label for="<?php echo $id ?>"><?php displayArticle($art); ?>

            <?php //si l'article n'est plus en stock
            if ($stock==0) {
                echo '<h3 class="indisponible"> Cet article est indisponible </h3>';
            } else {
                //sinon mettre un bouton checkbox pour ajouter l'article au panier?>
            <input class="checkbox" type="checkbox" name="<?php echo $id ?>" id="<?php echo $id ?>" />Sélectionner l'article</input>
            <?php
            }
        echo '<br /><br /><HR>'; ?>
            </label>
            <br/><br/>
        </div>
    <?php
    }
    //finir le formulaire avec un bouton submit et le fermer?>
    <input class="btn-lg" type="submit" value="Ajouter au panier" />
    <form>   
 
<?php
}

//========================================================================

// Cette fonction affiche un article
function displayClient(Client $client)
{
    echo $client->getId().'<br> - '.$client->getName().' est un client de la boutique. <br> Email : '.$client->getEmail().'<br> Code postal : '.$client->getPostal_code().'<br> Ville : '.$client->getCity().'<br><br>';
}

//======================================================================

//cette fonction affiche la liste des clients
function displayListeClients(ListeClients $listeClients){
    //pour chaque $client du tableau (récupéré avec getListeClients()) de l'objet ListeClients --> afficher $client
    // ATTENTION : on ne peut pas boucler sur un objet !! 
        foreach ($listeClients->getListeClients() as $client){
        displayClient($client);
    }


}