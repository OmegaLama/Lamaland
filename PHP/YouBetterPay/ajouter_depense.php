<?php
$connexion = mysqli_connect('localhost','lama','lama','db_test');
print_r($_POST);
echo '<br />';
echo '<br />';
echo '<br /> Nom depense: ', $_POST['nom_depense'];
echo '<br /> ID acheteur: ', $_POST['id_utilisateur_acheteur_depense'];
echo '<br /> ID participant: ', $_POST['id_utilisateur_particpant_depense'][0];
foreach ($_POST['id_utilisateur_particpant_depense'] as $id_utilisateur) {
    echo '<br />(boucle) ID participant: ', $id_utilisateur;
}
echo '<br /> Date depense: ', $_POST['date_depense'];
echo '<br /> Commentaire depense: ', $_POST['commentaire_depense_'];
echo '<br /> Etat soumettre: ', $_POST['soumettre'];


$preparation_requete_utilisateur= 'INSERT INTO y_utilisateurs (utilisateur_id, utilisateur_prenom, utilisateur_nom, utilisateur_pseudo, utilisateur_mail) VALUES (NULL, ?, ?, ?, ?)';

$requete_ajout_utilisateur = mysqli_prepare($connexion, $preparation_requete_utilisateur);
// On indique que que la requete repare doit associe le "?" a la variable qui contient l'ID de la depense, et que c'est un type Décimal
$ok = mysqli_stmt_bind_param($requete_ajout_utilisateur, 'ssss', $_POST['prenom_utilisateur'], $_POST['nom_utilisateur'], $_POST['pseudo_utilisateur'], $_POST['mail_utilisateur']);
$ok = mysqli_stmt_execute($requete_ajout_utilisateur);
$ok = mysqli_close($connexion);
header('location: utilisateurs.php');

?>