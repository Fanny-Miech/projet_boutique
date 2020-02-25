<?php

//appelle la base de données 
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bd_boutique;charset=utf8', 'fanny.miech', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

//======================================================


class Article {
    private $id;
    private $name;
    private $description;
    private $price;
    private $weight;
    private $image;
    private $stock;
    private $for_sale;
    private $Categories_id;

    public function __construct($id, $name, $description, $price, $weight, $image, $stock, $for_sale, $Categories_id){
        $this->id=$id;
        $this->name=$name;
        $this->desription=$description;
        $this->price=$price;
        $this->weight=$weight;
        $this->image=$image;
        $this->stock=$stock;
        $this->for_sale=$for_sale;
        $this->categories_id=$Categories_id;
    }

    public function getId(){return $this->id;}
    public function getName(){return $this->name;}
    public function getDescription(){return $this->description;}
    public function getPrice(){return $this->price;}
    public function getWeight(){return $this->weight;}
    public function getImage(){return $this->image;}
    public function getStock(){return $this->stock;}
    public function getFor_sale(){return $this->for_sale;}
    public function getCategoriesId(){return $this->categories_id;}

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

class Catalogue {
    private $cat=array();

    public function __construct(){
        //connection BDD + requête sql SELECT * from Articles
        $reponse = $bdd->query('select * from articles');
        while ($donnees = $reponse -> fetch()){
            //instancier des nouveaux articles via la base de données
            $article = new Article($donnees['id'], $donnees['name'], $donnees['description'],$donnees['price'],$donnees['weight'], $donnees['image'], $donnees['stock'], $donnees['for_sale'], $donnees['Categories_id']);
            //remplir le catalogue avec chaque article
            $cat[]=$article;
        }
    }

    public function getCat() {
        return $cat;
    }
}

$cat_boutique = new Catalogue();