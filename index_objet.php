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
