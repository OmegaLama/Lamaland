<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Utilisateurs - Youbetterpay</title>
</head>
<body>
<h1>You Better Pay</h1>
<?php include_once('menu.php'); ?>
<h2>Utilisateurs</h2>
<h3>Liste des utilisateurs</h3>

<?php
// Connexion et sélection de la base
$connexion = mysqli_connect('localhost','lama','lama','db_test');
$ok = mysqli_select_db($connexion,'diane') ;
// Exécution de la requête de sélection.
$requête = 'SELECT * FROM utilisateurs';
$résultat = mysqli_query($connexion,$requête);
// Lecture et affichage du résultat
while ($article = mysqli_fetch_assoc($résultat)) {
    echo $article['id'],' - ',$article['prenom'], " ",$article['nom'],' "',$article['pseudo'],'"','<br />';
}
// Déconnexion.
$ok = mysqli_close($connexion);
?>
</body>
</html>