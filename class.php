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
        $reponse = $bdd->query('select articles.id, taille, name, pointure, description, price, weight, image, stock, for_sale, Categories_id from articles left join chaussures on articles.id = chaussures.articles_id left join vetements on articles.id = vetements.articles_id  order by Categories_id');
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
//$cat_boutique = new Catalogue($bdd);
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


//========================================================================

class Vetement extends Article { //class Chaussure enfant de la classe Article
    protected $taille;
    public function __construct($taille, $id, $name, $description, $price, $weight, $image, $stock, $for_sale, $Categories_id) {
        parent::__construct($id, $name, $description, $price, $weight, $image, $stock, $for_sale, $Categories_id);
        $this->taille = $taille;
    }

    public function getTaille() {return $this->taille;}

}

//======================================================================

class Chaussure extends Article {
    protected $pointure;
    public function __construct($pointure, $id, $name, $description, $price, $weight, $image, $stock, $for_sale, $Categories_id) {
        parent::__construct($id, $name, $description, $price, $weight, $image, $stock, $for_sale, $Categories_id);
        $this->pointure = $pointure;
    }

    public function getPointure() {return $this->pointure;}

}

//========================================================================

class Panier {
    private $panier=array();
    private $quantité_init=1;

    public function __construct($bdd){
         //pour chaque article du catalogue
    $reponse = $bdd->query('select * from articles');
    while ($donnees = $reponse -> fetch()) {

    //si j'ai un POST => traiter le post pour créer le panier
        if (isset($_POST[$donnees['id']]) && !isset($_POST['supprimer_' . $donnees['id']])) {
            //si oui, ajouter l'article au panier
            $panier[] = $donnees;
    
            //initialise la quantité des artcicles à 1 =======> à l'envers
            foreach ($panier as $key => $article) {
                if (isset($_POST['quantite_de_' . $article['id']])) {
                    $panier [$key]['quantity'] = $_POST['quantite_de_' . $article['id']];
                } else {
                    $panier [$key]['quantity']= $quantité_init;
                }
            }
    
            //je teste si la quantité est bonne ========> ok
            foreach ($panier as $key => $article) {
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
                        $panier[$key]['quantity'] = $quantite;
                    }
                }
            }
        }
    }

    }

    public function add(){

    }

    public function update(){

    }

    public function delete(){

    }

    public function getPanier(){return $this->panier;}
    
}

?>