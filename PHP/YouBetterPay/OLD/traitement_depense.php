<?php
require "config.php";

$req = $connexion->prepare('INSERT INTO depense (nom, prix) VALUES(?, ?)');
$req->execute(array($_POST['intitule'], $_POST['montant']));

header('Location: index.php');
?>  