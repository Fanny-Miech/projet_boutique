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

//=========================================================================

function displayArticle($article) {

}

//======================================

function constructCatalogue() {
    $reponse = $bdd->query('select * from articles');
        while ($donnees = $reponse -> fetch()){
            $article = new Article($donnees['id'], $donnees['name'], $donnees['description'],$donnees['price'],$donnees['weight'], $donnees['image'], $donnees['stock'], $donnees['for_sale'], $donnees['Categories_id']);
            $cat[]=$article;
        }
}