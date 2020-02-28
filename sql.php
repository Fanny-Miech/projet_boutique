<?php

//======================================================================================
//=================== FONCTIONS REQUETES SQL ==========================================
//=======================================================================================


//fonction qui appelle le dernier Users_id
function last_users_id($bdd) {
    $reponse = $bdd->query('SELECT id FROM users ORDER BY id DESC LIMIT 1')->fetch();
    return $reponse[0];
}

//=============================================================================


//fonction qui appelle le dernier orders_id
function last_orders_id($bdd)
{
    $reponse = $bdd->query('SELECT id FROM orders ORDER BY id DESC LIMIT 1')->fetch();
    return $reponse[0];
}

//=================================================================================

//fonction qui retourne la date du jour
function today_date($bdd){
    $reponse = $bdd->query('SELECT CURRENT_DATE')->fetch();
    $date = $reponse[0];
    return $date;
}

//=====================================================================================

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

//================================================================================

//cette fonction crée un objet Article depuis une base de données
function articlePanier($bdd, $id) {
    $reponse = $bdd->query('select * FROM Articles where id = '. $id);
    $donnees = $reponse -> fetch();
    return $article = new Article($donnees['id'], $donnees['name'], $donnees['description'],$donnees['price'],$donnees['weight'], $donnees['image'], $donnees['stock'], $donnees['for_sale'], $donnees['Categories_id']);
}

//=======================================================

//cette fonction construit un catalogue d'objets article
function constructCat($bdd) {
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
        $cat[]=$article;
    }
    return $cat;
}

//===================================================================

function constructListClient($bdd) {
    $reponse = $bdd->query('select * from users');
    while ($donnees = $reponse -> fetch()){
        //instancier des nouveaux articles en objet Article via la base de données
        $client = new Client($donnees['id'], $donnees['name'], $donnees['email'],$donnees['adress'],$donnees['postal_code'], $donnees['city']);
        //remplir le catalogue avec chaque article
        $listClients[]=$client;
    }

    return $listClients;
    var_dump($listClients);
}