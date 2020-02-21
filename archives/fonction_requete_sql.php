<?php

//cette fonction appelle tous les articles présents dans la bdd
function list_articles($bdd) {
    $reponse = $bdd->query('select * from articles');
    while ($donnees = $reponse -> fetch())
    {
        echo '<p>'. $donnees['name'].' - '. $donnees['price'].' euros <p>';
    }
}

//cette fonction affiche la liste des produits en rupture de stock
function rupture_de_stock($bdd) {
    $reponse = $bdd->query('select * from articles where stock=0');
    while ($donnees = $reponse -> fetch())
    {
        echo '<p>'. $donnees['name'].' - '. $donnees['price'].' euros <p>';
    }
}

//cette fonction affiche les articles de la commande 1
function commande_1($bdd) {
    $reponse = $bdd->query('SELECT articles.name, articles.price, articles_commandes.quantity 
    FROM articles 
    INNER JOIN articles_commandes ON articles_commandes.Articles_id=articles.id
    WHERE Orders_id=1');
    while ($donnees = $reponse -> fetch()) {
        echo '<p>'. $donnees['name'].' - '. $donnees['price'].' euros'.' - '.$donnees['quantity'].'<p>';
    }
}

//cette fonction affiche les commandes passées par Charlize
function commandes_charlize($bdd) {
    $reponse = $bdd->query('SELECT orders.* 
    From orders 
    INNER JOIN users ON orders.Users_id=users.id
    WHERE users.name LIKE \'%Charlize%\'');
    while ($donnees = $reponse -> fetch()) {
    echo '<p> Commande n° '. $donnees['numero'].'<p>';
    }
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

//cette fonction ajoute un article
function add_article($bdd, $articles) {
    $req = $bdd->prepare('INSERT INTO articles(name, description, price, poids, image, stock, for_sale, Categories_id) 
    VALUES(:name, :description, :price, :poids, :image, :stock, :for_sale, :Categories_id)');
    $req->execute(array(
        'name' => $articles[0],
        'description' => $articles[1],
        'price' => $articles[2],
        'poids' => $articles[3],
        'image' => $articles[4],
        'stock' => $articles[5],
        'for_sale' => $articles[6],
        'Categories_id' => $articles[7]
        ));

    echo "L'article ".$articles[0]." a bien été ajouté !";
}

//cette fonction affiche tous les clients présents dans la bdd
function list_clients($bdd) {
    $reponse = $bdd->query('select * from users');
    while ($donnees = $reponse -> fetch())
    {
        echo '<p>'. $donnees['name'].' - '. $donnees['email'].'<p>';
    }
}


//cette fonction ajoute un client
function ajouter_client($bdd, $client) {
    $req = $bdd->prepare('INSERT INTO users(name, email, adress, postal_code, city) 
    VALUES(:name, :email, :adress, :postal_code, :city)');
    $req->execute(array(
        'name' => $client[0],
        'email' => $client[1],
        'adress' => $client[2],
        'postal_code' => $client[3],
        'city' => $client[4]
        ));
    echo "Le client ".$client[0]." a bien été ajouté !";
}
?>