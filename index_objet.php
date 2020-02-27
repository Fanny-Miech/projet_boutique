<?php
include ("fonctions.php");
include ("class.php");
include ("entete.php"); //appelle la page d'entete
?>


<header>
<h1>Notre catalogue</h1>
</header>

<div class="card-formulaire">
<?php
//instancie un nouvel objet Catalogue
$cat_boutique = new Catalogue($bdd);
//affiche le Catalogue
displayCat($cat_boutique);
?>
</div></br></br></br>

<div>
<h2> Liste des clients de la boutique </h2>
<?php
//instancie un nouvel objet ListeClients
$liste_boutique=new ListeClients($bdd);
//affiche la ListeClients
displayListeClients($liste_boutique);
?>
</div>


</body>
<?php
include ("footer.php");
?>
</html>
