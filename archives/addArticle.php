<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulaire</title>
</head>
<body>

<form method="post" action="displayArticle.php" enctype="multipart/form-data">
 
<p>
<h2>Formulaire d'envoi d'une nouvelle destination</h2><br />
<br />
<h3>Destination</h3> <input type="text" name="nom" /><br />
<br />
<h3>Photo</h3><input type="file" name="photo" /><br />
<br />
<h3>Prix </h3><input type="text" name="prix" /><br />
<br />
<br />
<input type="submit" value="Envoyer"> <br />
</p>
 
</form>
    
</body>
</html>