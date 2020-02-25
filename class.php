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

    public function __construct($bdd){
        //connection BDD + requête sql SELECT * from Articles
        $reponse = $bdd->query('select * from articles');
        while ($donnees = $reponse -> fetch()){
            //instancier des nouveaux articles via la base de données
            $article = new Article($donnees['id'], $donnees['name'], $donnees['description'],$donnees['price'],$donnees['weight'], $donnees['image'], $donnees['stock'], $donnees['for_sale'], $donnees['Categories_id']);
            //remplir le catalogue avec chaque article
            $this->cat[]=$article;
        }
    }

    public function getCat() {
        return $this->cat;
    }
}

$cat_boutique = new Catalogue($bdd);
$cat_boutique->getCat();
var_dump($cat_boutique);

// Cette fonction affiche un article
function displayArticle($article)
{
    echo '</br></br><div class="card">';
    echo '<img class="card-img-top" src="'.$article['image'].'" alt="'.$article['name'].'">';
    echo '<div class=card-body">';
    echo '<h2 class="card-title">'.$article['name'].'</h2>';
    echo '<h4 class="card-text"> Pour seulement '.$article['price'].' € !</h4>';
    echo '</div></div>';
}


//Cette fonction affiche le catalogue

function displayCat($catalogue){ ?>
    <form method="post" action="panierV4_bdd.php">
    <?php
    foreach ($catalogue as $art) {?>
        <div class="card-formulaire">
      
    <label for="<?php echo $art['id'] ?>"><?php displayArticle($art);?>
        <?php if ($art['stock']==0) {
        echo '<h3 class="indisponible"> Cet article est indisponible </h3>';
    }
    else {?>
        <input class="checkbox" type="checkbox" name="<?php echo $art['id'] ?>" id="<?php echo $art['id'] ?>" />Sélectionner l'article</input>
    <?php
    }
    echo '<br /><br /><HR>';

    }?>
    </label>
    <br/><br/>
    </div>

    <input class="btn-lg" type="submit" value="Ajouter au panier" />
    <form>
    </div>
</br></br></br>
<?php } 

//==========================================================================

include ("entete.php"); //appelle la page d'entete
?>


<header>
<h1>Notre catalogue</h1>
</header>

<?php 
//displayCat($cat_boutique);

