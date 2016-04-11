<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=db_youbetterpay;charset=utf8', 'youbetterpay', 'ZythPXPshHct0hsE');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

$req = $bdd->prepare('INSERT INTO participant (prenom, nom, pseudo) VALUES(?, ?, ?)');
$req->execute(array($_POST['prenom'], $_POST['nom'], $_POST['pseudo']));

header('Location: index.php');
?>