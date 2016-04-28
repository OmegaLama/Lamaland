<?php
print_r($_POST);
echo '<br />';
echo '<br />';
echo '<br />  Prenom utilisateur :', $_POST['prenom_utilisateur'];
echo '<br /> Nom utilisateur: ', $_POST['nom_utilisateur'];
echo '<br /> Pseudo utilisateur: ', $_POST['pseudo_utilisateur'];
echo '<br /> Mail utilisateur: ', $_POST['mail_utilisateur'];

$preparation_requete_utilisateur= 'INSERT INTO y_utilisateurs (utilisateur_id, utilisateur_prenom, utilisateur_nom, utilisateur_pseudo, utilisateur_mail) VALUES (NULL, ?, ?, ?, ?)';

?>