<?php
echo 'ID utilisateur :', $_POST['id_suppression_utilisateur'];

$connexion = mysqli_connect('localhost','lama','lama','db_test');

$preparation_requete_utilisateur= 'DELETE FROM y_utilisateurs u WHERE y_utilisateurs.utilisateur_id = 8';

$requete_ajout_utilisateur = mysqli_prepare($connexion, $preparation_requete_utilisateur);
// On indique que que la requete repare doit associe le "?" a la variable qui contient l'ID de la depense, et que c'est un type Décimal
$ok = mysqli_stmt_bind_param($requete_ajout_utilisateur, 'i', $_POST['id_suppression_utilisateur']);
$ok = mysqli_stmt_execute($requete_ajout_utilisateur);
$ok = mysqli_close($connexion);
?>