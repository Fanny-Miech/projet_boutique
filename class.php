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

    private $article=array();


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

        $this->article=['id'=>$this->id, 'name'=>$this->name, 'description'=>$this->description, 'price'=>$this->price, 'weight'=>$this->weight, 'image'=>$this->image, 'stock'=>$this->stock, 'for_sale'=>$this->for_sale, 'Categories_id'=>$this->Categories_id];
      
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

    public function getArticle(){return $this->article;}

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

    protected $panier=array();
    
    public function __construct(){
    }

    //cette méthode ajoute un nouvel objet au panier
    public function add($id){
        //si l'article est déjà dans le panier, ajouter 1 à la quantité
        if (array_key_exists($id, $this->panier)) {
            $this ->panier[$id] ++;
        }
        //sinon ajouter l'article au panier et assigner la quantité à 1
        else {
            $this->panier[$id] = 1;
        }        
    }

    //cette méthode modifie la quantité d'un article
    public function update($id, $qte){
        $this->panier[$id] = $qte;
    }

    //cette méthode supprime un article du panier
    public function delete($id){
        unset($this->panier[$id]);
    }

    //cette méthode renvoie le tableau $panier
    public function getPanier(){        
        return $this->panier;
    }

    public function totPanier(){
        $total=0;
        //pour chaque article du panier
        foreach ($this->panier as $id=>$quantite){
            try
        {
            $bdd = new PDO('mysql:host=localhost;dbname=bd_boutique;charset=utf8', 'fanny.miech', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
        //$article=getArticlePanier($bdd);
        $reponse = $bdd->query('select * FROM Articles where id = '. $id);
        $donnees = $reponse -> fetch();
        $article = new Article($donnees['id'], $donnees['name'], $donnees['description'],$donnees['price'],$donnees['weight'], $donnees['image'], $donnees['stock'], $donnees['for_sale'], $donnees['Categories_id']);
    

            $article=$article->getArticle();
            //ajouter le prix au total
            $total+=intval($article['price'])*intval($quantite);
        }
        // echo '<h3>Total panier : '.$total. ' € </h3>';
        return $total;
    }
    
}

//===============================================================================================

?>