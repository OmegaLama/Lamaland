<?php

$connexion = mysqli_connect('localhost','lama','lama','db_test');
// Fonction pour la sélection d'un article dont l'identifiant
// est passé en paramètre.
    $sql = 'DELETE FROM `y_utilisateurs` WHERE `utilisateur_id` = ?';
  // Préparer la requête.
  $ok = (bool) ($requête = @mysqli_prepare($connexion,$sql));
  // Lier les paramètres.
  if ($ok) {
      $ok = @mysqli_stmt_bind_param($requête,'i',$_POST['id_suppression_utilisateur']);
  }
  // Exécuter la requête.
  if ($ok) {
      $ok = @mysqli_stmt_execute($requête);
  }
  // Tester si tout s'est bien passé.
  if (! $ok) { // erreur quelque part
      if (! $requête) { // erreur lors de la préparation
          $erreur = @mysqli_error($connexion);
      } else { // erreur ailleurs
          $erreur = @mysqli_stmt_error($requête);
      }
  }
header('location: utilisateurs.php');
?>
