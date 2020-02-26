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
    protected $id;
    protected $name;
    protected $description;
    protected $price;
    protected $weight;
    protected $image;
    protected $stock;
    protected $for_sale;
    protected $Categories_id;


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
        $reponse = $bdd->query('select * from articles left join chaussures on articles.id = chaussures.articles_id left join vetements on articles.id = vetements.articles_id  order by Categories_id');
        while ($donnees = $reponse -> fetch()){
            if ($donnees['taille']!=null){
                $article = new Vetement($donnees['taille'],$donnees['id'], $donnees['name'], $donnees['description'],$donnees['price'],$donnees['weight'], $donnees['image'], $donnees['stock'], $donnees['for_sale'], $donnees['Categories_id']);
            }
            else if ($donnees['pointure']!=null){
                $article = new Chaussure($donnees['pointure'], $donnees['id'], $donnees['name'], $donnees['description'],$donnees['price'],$donnees['weight'], $donnees['image'], $donnees['stock'], $donnees['for_sale'], $donnees['Categories_id']); 
            }
            else {
                //instancier des nouveaux articles en objet Article via la base de données
                $article = new Article($donnees['id'], $donnees['name'], $donnees['description'], $donnees['price'], $donnees['weight'], $donnees['image'], $donnees['stock'], $donnees['for_sale'], $donnees['Categories_id']);
            }
            //remplir le catalogue avec chaque article
            $this->cat[]=$article;
        }
    }

    // méthode get pour retourner le catalogue (--> TABLEAU d'objets Article)
    public function getCat() {
        return $this->cat;
    }
}

//Instance d'un nouvel objet Catalogue : $cat_boutique
$cat_boutique = new Catalogue($bdd);
var_dump($cat_boutique->getCat());


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

      //1 attribut liste (tableau de client)
      private $listeClients=array();

      //__construct pour instancier un catalogue depuis une BDD
      public function __construct($bdd){
          //connection BDD + aller chercher tous les articles de la bdd (requête sql SELECT * from Articles)
          $reponse = $bdd->query('select * from users');
          while ($donnees = $reponse -> fetch()){
              //instancier des nouveaux articles en objet Article via la base de données
              $client = new Client($donnees['id'], $donnees['name'], $donnees['email'],$donnees['adress'],$donnees['postal_code'], $donnees['city']);
              //remplir le catalogue avec chaque article
              $this->listeClients[]=$client;
          }
      }
  
      // méthode get pour retourner le catalogue
      public function getListeClients() {
          return $this->listeClients;
      }

}

$liste_boutique=new ListeClients($bdd);

//========================================================================

class Chaussure extends Article { //class Chaussure enfant de la classe Article
    protected $taille;
    public function __construct($taille, $id, $name, $description, $price, $weight, $image, $stock, $for_sale, $Categories_id) {
        parent::__construct($id, $name, $description, $price, $weight, $image, $stock, $for_sale, $Categories_id);
        $this->taille = $taille;
    }

    public function getTaille() {return $this->taille;}

}

//======================================================================

class Vetement extends Article {
    protected $pointure;
    public function __construct($pointure, $id, $name, $description, $price, $weight, $image, $stock, $for_sale, $Categories_id) {
        parent::__construct($id, $name, $description, $price, $weight, $image, $stock, $for_sale, $Categories_id);
        $this->pointure = $pointure;
    }

    public function getPointure() {return $this->pointure;}

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
    echo '</div></div>';
}

//$articleTest = new Article (15, 'blabla', 'Voyage voyage', 500, 2, 'img/pattaya.jpg', 5, 1, 3);
//var_dump($articleTest);

//=======================================================================================

//Cette fonction affiche le catalogue

function displayCat(Catalogue $catalogue)
{
    //Je crée mon formlaire d'affichage du catalogue?>
    <form method="post" action="panierV4_bdd.php">
   
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

<div>
<h2> Liste des clients de la boutique </h2>
<?php
displayListeClients($liste_boutique);
?>
</div>


</body>
<?php
include ("footer.php");
?>
</html>

