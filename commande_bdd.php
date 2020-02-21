<?php 
session_start();
//var_dump($_SESSION);

//===============================================================================

include ("fonctions.php");//appelle la page fonction

//appelle la base de données 
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bd_boutique;charset=utf8', 'fanny.miech', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}



//============================================================

include ("entete.php"); //appelle la page d'entete

//===============================================================================
?>

<div class="card-formulaire">
<h2> Veuillez saisir vos coordonnées</h2>

<form method="post" action="commande_ok_bdd.php">        
            
            <!-- créer des champs pour entrer les coordonnées du client -->
            <h3>Nom</h3>
            <input type="text" name="name" id="name">
            <h3>Email</h3>
            <input type="text" name="email" id="email">
            <h3>Adresse</h3>
            <input type="text" name="adress" id="adress">
            <h3>Code postal</h3>
            <input type="number" name="postal_code" id="postal_code">
            <h3>Ville</h3>
            <input type="text" name="city" id="city">
    </br><br>
        <h2> Valider la commande </h2>
        <!-- envoyer la commande-->
        <input class="btn btn-primary btn-lg" type="submit" name="valider" value="valider"/>
    </form>

        </div>
    </br></br></br>

    </body>
<?php
include ("footer.php");
?>
</html>