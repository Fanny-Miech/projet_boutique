<?php

//appelle la base de données bd_boutique
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bd_boutique;charset=utf8', 'fanny.miech', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

//===============================================================================
//======================== CLASSES ===================================
//=====================================================================

class Article {

    //Les attributs de la classe articles
    private $id;
    private $name;
    private $description;
    private $price;
    private $weight;
    private $image;
    private $stock;
    private $for_sale;
    private $Categories_id;


    //comment instancier des objets Article -> fonction __construct
    public function __construct($id, $name, $description, $price, $weight, $image, $stock, $for_sale, $Categories_id){
        $this->id=$id;
        $this->name=$name;
        $this->description=$description;
        $this->price=$price;
        $this->weight=$weight;
        $this->image=$image;
        $this->stock=$stock;
        $this->for_sale=$for_sale;
        $this->Categories_id=$Categories_id;
    }

    //GETTER pour chaque attribut -> méthode qui retourne la valeur en dehors de la classe
    public function getId(){return $this->id;}
    public function getName(){return $this->name;}
    public function getDescription(){return $this->description;}
    public function getPrice(){return $this->price;}
    public function getWeight(){return $this->weight;}
    public function getImage(){return $this->image;}
    public function getStock(){return $this->stock;}
    public function getFor_sale(){return $this->for_sale;}
    public function getCategoriesId(){return $this->categories_id;}

    //SETTER pour chaque attribut -> méthode qui permet de définir une valeur
    public function setId(){return $this->id;}
    public function setName(){return $this->name;}
    public function setDescription(){return $this->description;}
    public function setPrice(){return $this->price;}
    public function setWeight(){return $this->weight;}
    public function setImage(){return $this->image;}
    public function setStock(){return $this->stock;}
    public function setFor_sale(){return $this->for_sale;}
    public function setCategoriesId(){return $this->categories_id;}
}

//==================================================================================

class Catalogue {

    //1 attribut catalogue (tableau d'articles)
    private $cat=array();

    //__construct pour instancier un catalogue depuis une BDD
    public function __construct($bdd){
        //connection BDD + aller chercher tous les articles de la bdd (requête sql SELECT * from Articles)
        $reponse = $bdd->query('select * from articles');
        while ($donnees = $reponse -> fetch()){
            //instancier des nouveaux articles en objet Article via la base de données
            $article = new Article($donnees['id'], $donnees['name'], $donnees['description'],$donnees['price'],$donnees['weight'], $donnees['image'], $donnees['stock'], $donnees['for_sale'], $donnees['Categories_id']);
            //remplir le catalogue avec chaque article
            $this->cat[]=$article;
        }
    }

    // méthode get pour retourner le catalogue
    public function getCat() {
        return $this->cat;
    }
}

//Instance d'un nouvel objet Catalogue : $cat_boutique
$cat_boutique = new Catalogue($bdd);

//var_dump($cat_boutique->getCat());


//=========================================================================================
class  Client {

    //les attributs d'un objet Client :
    private $id;
    private $name;
    private $email;
    private $adress;
    private $postal_code;
    private $city;

    //la construction d'un objet client :
    public function __construct($id, $name, $email, $adress, $postal_code, $city){
        $this->id=$id;
        $this->name=$name;
        $this->email=$email;
        $this->adress=$adress;
        $this->postal_code=$postal_code;
        $this->city=$city;
    }

    //GETTER pour chaque attribut -> méthode qui retourne la valeur en dehors de la classe
    public function getId(){return $this->id;}
    public function getName(){return $this->name;}
    public function getEmail(){return $this->email;}
    public function getPostal_code(){return $this->postal_code;}
    public function getAdress(){return $this->adress;}
    public function getCity(){return $this->city;}

    //SETTER pour chaque attribut -> méthode qui permet de définir une valeur
    public function setId(){return $this->id;}
    public function setName(){return $this->name;}
    public function setEmail(){return $this->email;}
    public function setPostal_code(){return $this->postal_code;}
    public function setAdress(){return $this->adress;}
    public function setCity(){return $this->city;}



}

//===================================================================

class ListeClients {


}

//====================================================================
//============================== FONCTIONS =================================
//====================================================================

// Cette fonction affiche un article
function displayArticle(Article $article)
{
    $image=$article->getImage();
    $price=$article->getPrice();
    $name=$article->getName();
    echo '</br></br><div class="card">';
    echo '<img class="card-img-top" src="'.$image.'" alt="'.$name.'">';
    echo '<div class=card-body">';
    echo '<h2 class="card-title">'.$name.'</h2>';
    echo '<h4 class="card-text"> Pour seulement '.$price.' € !</h4>';
    echo '</div></div>';
}

//$articleTest = new Article (15, 'rovaniemi', 'Voyage voyage', 500, 2, 'img/pattaya.jpg', 5, 1, 3);
//var_dump($articleTest);

//=======================================================================================

//Cette fonction affiche le catalogue

function displayCat(Catalogue $catalogue)
{
    //Je crée mon formlaire d'affichage du catalogue?>
    <form method="post" action="panierV4_bdd.php">
   
   <?php
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
//======================== HTML =======================================
//==========================================================================

include ("entete.php"); //appelle la page d'entete
?>


<header>
<h1>Notre catalogue</h1>
</header>

<div class="card-formulaire">
<?php 
//displayArticle($articleTest);
displayCat($cat_boutique);
?>
</div></br></br></br>


</body>
<?php
include ("footer.php");
?>
</html>

